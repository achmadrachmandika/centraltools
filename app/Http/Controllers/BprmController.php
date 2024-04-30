<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bprm;
use App\Models\Bpm;
use App\Models\project;
use Illuminate\Support\Facades\DB; 

class BprmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan daftar semua data BPRM
        $bprms = Bprm::all();
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
        return view('bprm.create', compact('bpms','daftar_projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
          'no_konversi' => 'required',
            'nomor_bpm' => 'required|exists:bpms,nomor_bpm',
            'project' => 'required',
            'no_bprm' => 'required',
            'jumlah' => 'required',
            'tgl_bprm' => 'required',
            'head_number' => 'required',
        // Validasi untuk material dapat ditambahkan sesuai kebutuhan
    ]);

    // Mengumpulkan data yang diperlukan untuk disimpan
    $data = [
            'no_konversi' => 'required',
            'nomor_bpm' => 'required|exists:bpms,nomor_bpm',
            'project' => 'required',
            'no_bprm' => 'required',
            'jumlah' => 'required',
            'tgl_bprm' => 'required',
            'head_number' => 'required',
    ]; // Pastikan untuk menutup kurung kurawal di sini
        
          // Loop untuk mengumpulkan data material
    for ($i = 1; $i <= 10; $i++) {
        $material = [
            'nama_material_' . $i => $request->input('nama_material_' . $i),
            'kode_material_' . $i => $request->input('kode_material_' . $i),
            'spek_material_' . $i => $request->input('spek_material_' . $i),
            'jumlah_material_' . $i => $request->input('jumlah_material_' . $i),
            'satuan_material_' . $i => $request->input('satuan_material_' . $i),
        ];

        // Gabungkan data material ke dalam data utama
        $data = array_merge($data, $material);
    }

    // Simpan data ke dalam database
    Bprm::create($data);

    return redirect()->route('bprm.index')->with('success', 'BOM created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Menampilkan detail data BPRM dengan ID tertentu
        $bprm = Bprm::findOrFail($id);
        return view('bprm.show', compact('bprm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    // Menampilkan form untuk mengedit data BPRM dengan ID tertentu
    $bprm = Bprm::findOrFail($id);
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
        // Temukan data BPRM yang akan dihapus
        $bprm = Bprm::findOrFail($id);

        // Hapus data BPRM
        $bprm->delete();

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

    
        
}
