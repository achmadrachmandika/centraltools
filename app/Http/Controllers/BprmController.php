<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bprm;
use App\Models\Bpm;
use App\Models\project;
use App\Models\Material;
use App\Models\notification;
use App\Models\project_material;
use App\Models\BprmMaterial;
use App\Models\Bagian;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BprmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    // Mendapatkan semua data BPRM tanpa pagination
    $bprms = Bprm::latest()->get();
 
      // Debug untuk melihat data sebelum dikirim ke view


    // Data dari model Notification
    $dataNotifs = Notification::whereNotNull('nomor_bprm')->get();

    // Menggabungkan data Notifikasi ke dalam data BPRM berdasarkan nomor_bprm
    $bprms->transform(function ($bprm) use ($dataNotifs) {
        $notif = $dataNotifs->where('nomor_bprm', $bprm->nomor_bprm)->first();
        if ($notif) {
            $bprm->status = $notif->status;
            $bprm->id_notif = $notif->id;
        } else {
            $bprm->status = 'seen';
        }
        return $bprm;
    });

    // Mendapatkan nama project berdasarkan id project
    foreach ($bprms as $bprm) {
        $project = Project::where('id', $bprm->project)->first();
        if ($project) {
            $bprm->project = $project->nama_project;
        }
    }



    return view('bprm.index', compact('bprms'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bpms = Bpm::all();
        $daftar_projects = project::all();
        $bagians = Bagian::all();
        // Menampilkan form untuk membuat data baru
        return view('bprm.create', compact('bpms', 'daftar_projects', 'bagians'));
    }

    public function getDataBprm(){
           // Mendapatkan semua data BPRM tanpa pagination
    $bprms = Bprm::with(['project'])->latest();
    
    // dd($bprms[0]->BprmMaterials[0]->material->projectMaterials);
    return DataTables::of($bprms)
        ->addColumn('materials', function ($bprm) {
    return '<div class="materials-wrapper">' . 
        $bprm->bprmMaterials->map(function ($bm) {
            if ($bm->material) {
                return '<div class="material-item">(' . $bm->material->kode_material . ') ' . $bm->material->nama . '</div>';
            } else {
                return '<div class="material-item text-danger">Material tidak ditemukan</div>';
            }
        })->implode('') .
    '</div>';
})

        ->addColumn('jumlah_materials', function ($bprm) {
            return $bprm->bprmMaterials->pluck('jumlah_material')->implode('<br>');
        })
        ->addColumn('project', function ($bprm) {
            $project = \App\Models\Project::find($bprm->project);
            return $project ? $project->nama_project : 'Unknown Project';
        })
        ->addColumn('action', function ($bprm) {
            return '<a class="btn btn-info btn-sm mr-2"
                        href="' . route('bprm.show', ['bprm' => $bprm->nomor_bprm, 'id_notif' => $bprm->id_notif]) . '">
                        <i class="fas fa-print"></i> Print
                    </a>';
        })
          ->addColumn('bagian', function ($bprm) {
                return $bprm->bagian;
            })

        ->rawColumns(['materials', 'jumlah_materials', 'action', 'bagian']) // biar HTML tidak di-escape
        ->make(true);

    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'no_spm' => 'required|unique:bprms',
        'project' => 'required|string',
        'bagian' => 'required|string|exists:bagians,nama_bagian',
        'nama_admin' => 'required|string',
        'tgl_bprm' => 'required|date',
    ]);

    $data = [
        'nomor_bprm' => time(), // Buat ID unik berdasarkan timestamp
        'no_spm' => $validated['no_spm'],
        'project' => $validated['project'],
        'bagian' => $validated['bagian'],
        'nama_admin' => $validated['nama_admin'],
        'tgl_bprm' => $validated['tgl_bprm'],
    ];

    // Memasukkan data material
    $materials = [];
    for ($i = 1; $i <= 10; $i++) {
        $kodeMaterialKey = "kode_material_$i";
        $jumlahMaterialKey = "jumlah_material_$i";
        $satuanMaterialKey = "satuan_material_$i";
        $lokasiMaterialKey = "lokasi_material_$i";

        if ($request->filled($kodeMaterialKey)) {
            // Ambil material berdasarkan kode_material
            $material = Material::where('kode_material', $request->$kodeMaterialKey)->where('lokasi', $request->$lokasiMaterialKey)->first();

            if (!$material) {
                return back()->withErrors(["message" => "Material dengan kode {$request->$kodeMaterialKey} tidak ditemukan."]);
            }

            // Cek apakah material tersedia dalam project_material
            $projectMaterial = project_material::where('material_id', $material->id)
                ->where('kode_project', $validated['project'])
                ->first();

            if (!$projectMaterial) {
                return back()->withErrors(["message" => "Material dengan kode {$request->$kodeMaterialKey} tidak tersedia dalam proyek ini."]);
            }
            // dump($projectMaterial->jumlah , $request->$jumlahMaterialKey, $material->id, $request->$kodeMaterialKey);
            // dd($projectMaterial->jumlah < $request->$jumlahMaterialKey);

            // Pastikan stok cukup sebelum mengurangi
            if ($projectMaterial->jumlah < $request->$jumlahMaterialKey) {
                return back()->withErrors(["message" => "Stok material {$material->kode_material} dalam proyek ini tidak mencukupi."]);
            }

            // Simpan data material
            $materials[] = [
                'material_id' => $material->id,
                'jumlah_material' => $request->$jumlahMaterialKey,
                'satuan_material' => $request->$satuanMaterialKey,
                'kode_project' => $validated['project'],
            ];
        }
    }

    DB::beginTransaction();
    try {
        // Simpan data BPRM
        $bprm = Bprm::create($data);

        // Simpan data ke tabel bprm_materials dan update stok
        foreach ($materials as $material) {
            // Kurangi stok dalam project_material
            project_material::where('material_id', $material['material_id'])
                ->where('kode_project', $material['kode_project'])
                ->decrement('jumlah', $material['jumlah_material']);

            // Update total stok di tabel materials setelah perubahan dalam project_material
            $totalStok = project_material::where('material_id', $material['material_id'])->sum('jumlah');
            Material::where('id', $material['material_id'])->update(['jumlah' => $totalStok]);

            // Simpan data ke tabel bprm_materials
            BprmMaterial::create([
                'nomor_bprm' => $bprm->nomor_bprm,
                'material_id' => $material['material_id'],
                'jumlah_material' => $material['jumlah_material'],
                'satuan_material' => $material['satuan_material'],
            ]);
        }

        DB::commit();
        return redirect()->route('bprm.index')->with('success', 'BPRM berhasil dibuat.');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors(['message' => 'Terjadi kesalahan saat menyimpan data. Error: ' . $e->getMessage()]);
    }
}







    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Menampilkan detail data BPRM dengan ID tertentu
        $bprm = Bprm::where('nomor_bprm', $id)->first();

        $projectName = project::where('id', $bprm->project)->pluck('nama_project')->first();

        $bprm->project = $projectName;
        return view('bprm.show', compact('bprm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Menampilkan form untuk mengedit data BPRM dengan ID tertentu

        $bprm = Bprm::where('nomor_bprm', $id);
        $bpms = Bpm::all(); // Mendapatkan semua Nomor BPM
        return view('bprm.edit', compact('bprm', 'bpms'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data masukan
        $data = $request->validate([
            'no_konversi' => 'required',
            'nomor_bpm' => 'required|exists:bprms,nomor_bpm',
            'project' => 'required',
            'nama_admin' => 'required|string',
            'no_bprm' => 'required',
            'jumlah_bprm' => 'required',
            'tgl_bprm' => 'required',
            'head_number' => 'required',
        ]);

        // Dapatkan data BPRM yang akan diupdate
        $bprm = Bprm::findOrFail($id);

        // Update data BPRM
        $bprm->update($data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('bprm.index')->with('success', 'Data BPRM berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        $bprm = Bprm::where('nomor_bprm', $id)->first();

        for ($i = 1; $i <= 10; $i++) {
            $kodeMaterial = 'kode_material_' . $i;
            $jumlahMaterial = 'jumlah_material_' . $i;

            if ($bprm->$kodeMaterial !== NULL) {

                $stokMaterial = Material::where('kode_material', $bprm->$kodeMaterial)->first();
                $stokMaterial = intval($stokMaterial->jumlah);
                $jumlahMaterial = intval($bprm->$jumlahMaterial);

                $sum = $stokMaterial + $jumlahMaterial;


                Material::where('kode_material', $bprm->$kodeMaterial)->update(['jumlah' => $sum]);
            }
        }

        $bprm = Bprm::where('nomor_bprm', $id)->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('bprm.index')->with('success', 'Data BPRM berhasil dihapus.');
    }

    public function searchNoBPM(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('bpms')
                ->where('nomor_bpm', 'LIKE', "%{$query}%")
                ->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:absolute;margin:-10px 0px 0px 12px; max-height: 120px; overflow-y: auto;">';

            foreach ($data as $row) {
                $output .= '<li style="background-color: white; list-style-type: none; cursor: pointer; padding-left:10px" onmouseover="this.style.backgroundColor=\'grey\'" onmouseout="this.style.backgroundColor=\'initial\'">'
                    . $row->nomor_bpm .
                    '</li>';
            }

            $output .= '</ul>';
            return $output;
        }
    }

    

   public function searchCodeMaterial(Request $request)
{
    if ($request->has('query')) {
        $query = $request->get('query');
        $project = $request->input('project_id');
        $lokasi = trim(strtolower($request->input('lokasi'))); // Normalisasi input lokasi

        // Ambil data material sesuai filter
        $data = Material::where('kode_material', 'LIKE', "%{$query}%")
                        ->where('project', 'LIKE', "%{$project}%")
                        ->where('lokasi', $lokasi)
                        ->get();

        // Jika tidak ada hasil
        if ($data->isEmpty()) {
            return response()->json('<ul class="dropdown-menu" style="display:block; position:absolute; max-height: 120px; overflow-y: auto;"><li style="padding:10px; color:grey;"></li></ul>');
        }

        // Menyusun output hasil pencarian
        $output = '<ul class="dropdown-menu" style="display:block; position:absolute; max-height: 120px; overflow-y: auto;">';
        foreach ($data as $row) {
            $output .= '
            <li data-satuan="' . $row->satuan . '" 
                data-nama="' . $row->nama . '" 
                data-spek="' . $row->spek . '"  
                data-lokasi="' . $row->lokasi . '"
                style="background-color: white; list-style-type: none; cursor: pointer; padding:10px;"
                onmouseover="this.style.backgroundColor=\'grey\'" 
                onmouseout="this.style.backgroundColor=\'initial\'">'
                . $row->kode_material . '
            </li>';
        }
        $output .= '</ul>';

        return response()->json($output);
    }
}

public function autocompleteNoSpm(Request $request)
{
    $query = $request->get('query');
    $data = Spm::where('no_spm', 'LIKE', "%{$query}%")->get();

    if ($data->isEmpty()) {
        return response()->json('<ul class="dropdown-menu" style="display:block; position:absolute; z-index:999; max-height: 120px; overflow-y: auto;"><li style="padding:10px; color:grey; font-size: 0.85rem;"></li></ul>');
    }

    $output = '<ul class="dropdown-menu" style="display:block; position:absolute; z-index:999; max-height: 120px; overflow-y: auto;">';
    foreach ($data as $spm) {
        $output .= '<li style="padding:10px; cursor:pointer;" 
                    data-nama_1="' . $spm->nama_material_1 . '" 
                    data-satuan_1="' . $spm->satuan_1 . '" 
                    data-spek_1="' . $spm->spek_1 . '" 
                    data-kode_1="' . $spm->kode_material_1 . '" 
                    data-jumlah_1="' . $spm->jumlah_material_1 . '" 
                    data-lokasi_1="' . $spm->lokasi_material_1 . '">'
                    . $spm->no_spm . '</li>';
    }
    $output .= '</ul>';

    return response()->json($output);
}


}
