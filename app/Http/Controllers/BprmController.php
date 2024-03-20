<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bprm;
use App\Models\Bpm;

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
        // Menampilkan form untuk membuat data baru
        return view('bprm.create', compact('bpms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data masukan
        $data = $request->validate([
            'no_konversi' => 'required',
            'nomor_bpm' => 'required',
            'oka' => 'required',
            'no_bprm' => 'required',
            'jumlah_bprm' => 'required',
            'tgl_bprm' => 'required',
            'head_number' => 'required',
        ]);

        // Simpan data baru ke dalam database
        Bprm::create($data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('bprm.index')->with('success', 'Data BPRM berhasil dibuat.');
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
            'oka' => 'required',
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
}
