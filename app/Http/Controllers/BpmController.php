<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bpm;
use App\Models\Material;
use App\Models\project;
use App\Models\notification;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use Exception;
use App\Models\project_material;
use App\Models\BpmMaterial;



class BpmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Mendapatkan daftar data BPM dengan pagination
      $bpms = Bpm::with('bpmMaterials.material')->get();

    // Data dari model Notification
    $dataNotifs = Notification::whereNotNull('id')->get();

    // Menggabungkan data Notifikasi ke dalam data BPM berdasarkan no_bpm
    $bpms->transform(function ($bpm) use ($dataNotifs) {
        $notif = $dataNotifs->where('no_bpm', $bpm->no_bpm)->first();
        if ($notif) {
            $bpm->status = $notif->status;
            $bpm->id_notif = $notif->id;
        } else {
            $bpm->status = 'seen';
        }
        return $bpm;
    });

    foreach ($bpms as $bpm) {
        $project = project::where('id', $bpm->project)->first();
        $bpm->project = $project ? $project->nama_project : 'Unknown Project';
    }

    return view('bpm.index', compact('bpms'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kode_materials = Material::all();
        $daftar_projects = project::all();
        return view('bpm.create', compact('kode_materials', 'daftar_projects'));
    }


public function getDataBpm()
{
    $bpms = Bpm::with(['bpmMaterials.material'])->latest();

    // Ambil semua notifikasi
    $dataNotifs = Notification::whereNotNull('no_bpm')->get();

    return DataTables::of($bpms)
        ->addColumn('status', function ($bpm) use ($dataNotifs) {
            $notif = $dataNotifs->where('no_bpm', $bpm->no_bpm)->first();
            return $notif ? $notif->status : 'seen';
        })
        ->addColumn('id_notif', function ($bpm) use ($dataNotifs) {
            $notif = $dataNotifs->where('no_bpm', $bpm->no_bpm)->first();
            return $notif ? $notif->id : null;
        })
        ->addColumn('materials', function ($bpm) {
            return $bpm->bpmMaterials->map(function ($bm) {
                return $bm->material 
                    ? '(' . $bm->material->kode_material . ') ' . $bm->material->nama 
                    : '<span class="text-danger">Material tidak ditemukan</span>';
            })->implode('<br>');
        })
        ->addColumn('jumlah_materials', function ($bpm) {
            return $bpm->bpmMaterials->pluck('jumlah_material')->implode('<br>');
        })
        ->addColumn('project', function ($bpm) {
            $project = \App\Models\project::find($bpm->project);
            return $project ? $project->nama_project : 'Unknown Project';
        })
        ->addColumn('action', function ($bpm) {
            $idNotif = Notification::where('no_bpm', $bpm->no_bpm)->first()?->id;
            return '<a class="btn btn-info btn-sm mr-2"
                        href="' . route('bpm.show', ['bpm' => $bpm->id, 'id_notif' => $idNotif]) . '">
                        <i class="fas fa-show"></i> Lihat
                    </a>';
        })
        ->rawColumns(['materials', 'jumlah_materials', 'action']) // biar <br> dan HTML tampil
        ->make(true);
}



    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'no_bpm' => 'required|numeric',
        'project' => 'required|string',
        'lokasi' => 'required|string',
        'tgl_permintaan' => 'required|string',
    ]);

    DB::beginTransaction();
    try {
        // Simpan data BPM
        $bpm = Bpm::create([
            'no_bpm' => $validated['no_bpm'],
            'project' => $validated['project'],
            'lokasi' => $validated['lokasi'],
            'tgl_permintaan' => $validated['tgl_permintaan'],
        ]);

        $materials = [];
        for ($i = 1; $i <= 10; $i++) {
            $kodeMaterialKey = "kode_material_$i";
            $jumlahMaterialKey = "jumlah_material_$i";
            $satuanMaterialKey = "satuan_material_$i";
            $lokasiMaterialKey = "lokasi_material_$i";

            // dd($request->$lokasiMaterialKey);

            if ($request->filled($kodeMaterialKey)) {
                // Cari material berdasarkan kode_material
                $material = Material::where('kode_material', $request->$kodeMaterialKey)->where('lokasi', $request->$lokasiMaterialKey)->first();



        
                if (!$material) {
                    return back()->withErrors(["message" => "Material dengan kode {$request->$kodeMaterialKey} tidak ditemukan."]);
                }

                // Simpan data material untuk BPM
                $materials[] = [
                    'no_bpm' => $validated['no_bpm'],
                    'material_id' => $material->id, // Gunakan material_id sesuai model terbaru
                    'jumlah_material' => $request->$jumlahMaterialKey,
                    'satuan_material' => $request->$satuanMaterialKey,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert ke tabel bpm_materials jika ada data material
        if (!empty($materials)) {
            BpmMaterial::insert($materials);

            // Kurangi stok material
            // Update stok di tabel materials dan project_material
foreach ($materials as $materialData) {
    $material = Material::find($materialData['material_id']);
    if ($material) {
        // Tambah stok ke project_material berdasarkan proyek
        $projectMaterial = project_material::where('material_id', $material->id)
            ->where('kode_project', $validated['project'])
            ->first();
            //       dump($projectMaterial->jumlah , $request->$jumlahMaterialKey, $material->id, $request->$kodeMaterialKey);
            // dd($projectMaterial->jumlah < $request->$jumlahMaterialKey);
        if ($projectMaterial) {
            // Jika material sudah ada dalam proyek, tambahkan stok
            $projectMaterial->increment('jumlah', $materialData['jumlah_material']);
        } else {
            // Jika belum ada, buat data baru
            project_material::create([
                'material_id' => $material->id,
                'kode_project' => $validated['project'],
                'jumlah' => $materialData['jumlah_material'],
            ]);
        }

        // Tambahkan stok total di tabel materials
        // Hitung ulang total stok di semua proyek setelah BPM ditambahkan
$totalStok = project_material::where('material_id', $material->id)->sum('jumlah');
$material->update(['jumlah' => $totalStok]);

    }
}

        }

        DB::commit();
        return redirect()->route('bpm.index')->with('success', 'BPM berhasil dibuat.');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors(['message' => 'Terjadi kesalahan saat menyimpan BPM. Error: ' . $e->getMessage()]);
    }
}







    public function diterima($id)
    {

        return redirect()->route('bpm.index')->with('success', 'Status BPM ' . $id . ' Berubah Menjadi Diterima!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $bpm = Bpm::with('bpmMaterials.material')->findOrFail($id);
    $projectName = project::where('id', $bpm->project)->pluck('nama_project')->first();

    $bpm->project = $projectName;
    return view('bpm.show', compact('bpm'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bpm $bpm)
    {
        $kode_materials = Material::all();
        $daftar_projects = project::all();
        return view('bpm.edit', compact('bpm', 'kode_materials', 'daftar_projects'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bpm $bpm)
    {
        $validated = $request->validate([
            'no_spm' => 'required|exists:spms,no_spm',
            'project' => 'required|string',
            'tgl_permintaan' => 'required|string',
        ]);

        $data = [
            'no_spm' => $validated['no_spm'],
            'project' => $validated['project'],
            'tgl_permintaan' => $validated['tgl_permintaan'],
        ];

        $bpm->update($data);
        return redirect()->route('bpm.index')->with('success', 'BPM updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bpm $bpm)
    {
        $bpm->delete();
        return redirect()->route('bpm.index')->with('success', 'BPM deleted successfully.');
    }

    // public function searchCodeMaterial(Request $request)
    // {
    //     if ($request->get('query')) {
    //         $query = $request->get('query');
    //         $project = $request->input('project_id');
    //         $data = Material::where('kode_material', 'LIKE', "%{$query}%")->where('project', 'LIKE', "%{$project}%")->get();

    //         $output = '<ul class="dropdown-menu" style="display:block; position:absolute;; max-height: 120px; overflow-y: auto;">';

    //         foreach ($data as $row) {
    //             $output .= '
    //             <a href="#" style="text-decoration:none; color:black;">
    //                 <li data-satuan="' . $row->satuan . '" data-nama="' . $row->nama . '" data-spek="' . $row->spek . '"  style="background-color: white; list-style-type: none; cursor: pointer; padding-left:10px" onmouseover="this.style.backgroundColor=\'grey\'" onmouseout="this.style.backgroundColor=\'initial\'">'
    //                 . $row->kode_material .
    //                 '</li>
    //             </a>
    //         ';
    //         }

    //         $output .= '</ul>';
    //         echo $output;
    //     }
    // }
    public function searchCodeMaterial(Request $request)
{
    if ($request->has('query')) {
        $query = $request->input('query');
        $project = $request->input('project_id');
         $lokasi = trim(strtolower($request->input('lokasi'))); // Normalisasi input lokasi

        // Ambil material berdasarkan kode_material dan lokasi proyek (atau kriteria relevan lainnya)
           // Ambil data material sesuai filter
        $data = Material::where('kode_material', 'LIKE', "%{$query}%")
                        ->where('project', 'LIKE', "%{$project}%")
                        ->where('lokasi', $lokasi)
                        ->get();

                         if ($data->isEmpty()) {
            return response()->json('<ul class="dropdown-menu" style="display:block; position:absolute; max-height: 120px; overflow-y: auto;"><li style="padding:10px; color:grey;">Tidak ditemukan</li></ul>');
        }

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


    public function searchNoSPM(Request $request)
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
            return response()->json('<ul class="dropdown-menu" style="display:block; position:absolute; max-height: 20px; overflow-y: auto;"><li style="padding:10px; color:grey;"></li></ul>');
        }

        // Menyusun output hasil pencarian
        $output = '<ul class="dropdown-menu" style="display:block; position:absolute; max-height: 120px; overflow-y: auto;">';
        foreach ($data as $row) {
            $output .= '
            <li data-satuan="' . $row->satuan . '" 
                data-nama="' . $row->nama . '" 
                data-spek="' . $row->spek . '"  
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
}
