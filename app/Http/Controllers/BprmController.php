<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bprm;
use App\Models\Bpm;
use App\Models\project;
use App\Models\Material;
use App\Models\notification;
use App\Models\project_material;
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
        // Menampilkan form untuk membuat data baru
        return view('bprm.create', compact('bpms', 'daftar_projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_spm' => 'required|unique:bprms',
            'project' => 'required|string',
            'bagian' => 'required|string',
            'nama_admin' => 'required|string',
            'tgl_bprm' => 'required',
        ]);
        $data = [
            'no_spm' => $validated['no_spm'],
            'project' => $validated['project'],
            'bagian' => $validated['bagian'],
            'nama_admin' => $validated['nama_admin'],
            'tgl_bprm' => $validated['tgl_bprm'],
            'nama_material_1' => $request->nama_material_1,
            'kode_material_1' => $request->kode_material_1,
            'spek_material_1' => $request->spek_material_1,
            'jumlah_material_1' => $request->jumlah_material_1,
            'satuan_material_1' => $request->satuan_material_1,
            'nama_material_2' => $request->nama_material_2,
            'kode_material_2' => $request->kode_material_2,
            'spek_material_2' => $request->spek_material_2,
            'jumlah_material_2' => $request->jumlah_material_2,
            'satuan_material_2' => $request->satuan_material_2,
            'nama_material_3' => $request->nama_material_3,
            'kode_material_3' => $request->kode_material_3,
            'spek_material_3' => $request->spek_material_3,
            'jumlah_material_3' => $request->jumlah_material_3,
            'satuan_material_3' => $request->satuan_material_3,
            'nama_material_4' => $request->nama_material_4,
            'kode_material_4' => $request->kode_material_4,
            'spek_material_4' => $request->spek_material_4,
            'jumlah_material_4' => $request->jumlah_material_4,
            'satuan_material_4' => $request->satuan_material_4,
            'nama_material_5' => $request->nama_material_5,
            'kode_material_5' => $request->kode_material_5,
            'spek_material_5' => $request->spek_material_5,
            'jumlah_material_5' => $request->jumlah_material_5,
            'satuan_material_5' => $request->satuan_material_5,
            'nama_material_6' => $request->nama_material_6,
            'kode_material_6' => $request->kode_material_6,
            'spek_material_6' => $request->spek_material_6,
            'jumlah_material_6' => $request->jumlah_material_6,
            'satuan_material_6' => $request->satuan_material_6,
            'nama_material_7' => $request->nama_material_7,
            'kode_material_7' => $request->kode_material_7,
            'spek_material_7' => $request->spek_material_7,
            'jumlah_material_7' => $request->jumlah_material_7,
            'satuan_material_7' => $request->satuan_material_7,
            'nama_material_8' => $request->nama_material_8,
            'kode_material_8' => $request->kode_material_8,
            'spek_material_8' => $request->spek_material_8,
            'jumlah_material_8' => $request->jumlah_material_8,
            'satuan_material_8' => $request->satuan_material_8,
            'nama_material_9' => $request->nama_material_9,
            'kode_material_9' => $request->kode_material_9,
            'spek_material_9' => $request->spek_material_9,
            'jumlah_material_9' => $request->jumlah_material_9,
            'satuan_material_9' => $request->satuan_material_9,
            'nama_material_10' => $request->nama_material_10,
            'kode_material_10' => $request->kode_material_10,
            'spek_material_10' => $request->spek_material_10,
            'jumlah_material_10' => $request->jumlah_material_10,
            'satuan_material_10' => $request->satuan_material_10,
        ];

        // Simpan data ke dalam database
        DB::beginTransaction();
        // Buat BPRM
        $bprm = Bprm::create($data);

        // Dapatkan BPRM berdasarkan no_spm
        $bprm = Bprm::where('no_spm', $data['no_spm'])->first();

        for ($i = 1; $i <= 10; $i++) {
            $kodeMaterial = 'kode_material_' . $i;
            $jumlahMaterial = 'jumlah_material_' . $i;

            if ($bprm->$kodeMaterial !== NULL) {
                $stokProjectMaterial = project_material::where('kode_material', $bprm->$kodeMaterial)
                    ->where('kode_project', $data['project'])
                    ->first();

                if ($stokProjectMaterial) {
                    $stokProjectMaterialJumlah = intval($stokProjectMaterial->jumlah);
                    $jumlahMaterial = intval($bprm->$jumlahMaterial);

                    $sum = $stokProjectMaterialJumlah - $jumlahMaterial;

                    if ($sum < 0) {
                        // Stok tidak mencukupi, rollback transaksi dan tampilkan pesan kesalahan
                        return back()->withErrors(['message' => 'Jumlah stok untuk ' . $bprm->$kodeMaterial . ' tersisa.'. $stokProjectMaterialJumlah]);
                    }

                    project_material::where('kode_material', $bprm->$kodeMaterial)
                        ->where('kode_project', $data['project'])
                        ->update(['jumlah' => $sum]);

                    $jumlahAkhir = project_material::where('kode_material', $bprm->$kodeMaterial)
                        ->sum('jumlah');

                    Material::where('kode_material', $bprm->$kodeMaterial)
                        ->update(['jumlah' => $jumlahAkhir]);
                }
            }
        }

        // Commit transaksi jika semua operasi berhasil
        DB::commit();

        return redirect()->route('bprm.index')->with('success', 'BPRM created successfully.');
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
        if ($request->get('query')) {
            $query = $request->get('query');
            $project = $request->input('project_id');
            $lokasi = $request->input('lokasi');
            $lokasi = strtolower($lokasi);
            $data = Material::where('kode_material', 'LIKE', "%{$query}%")->where('project', 'LIKE', "%{$project}%")->where('lokasi', $lokasi)->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:absolute;; max-height: 120px; overflow-y: auto;">';

            foreach ($data as $row) {
                $output .= '
                <a href="#" style="text-decoration:none; color:black;">
                    <li data-satuan="' . $row->satuan . '" data-nama="' . $row->nama . '" data-spek="' . $row->spek . '"  style="background-color: white; list-style-type: none; cursor: pointer; padding-left:10px" onmouseover="this.style.backgroundColor=\'grey\'" onmouseout="this.style.backgroundColor=\'initial\'">'
                    . $row->kode_material .
                    '</li>
                </a>
            ';
            }

            $output .= '</ul>';
            echo $output;
        }
    }
}
