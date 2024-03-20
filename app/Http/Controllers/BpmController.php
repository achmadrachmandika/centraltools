<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bpm;
use App\Models\KodeMaterial;


class BpmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bpms = Bpm::all();
        return view('bpm.index', compact('bpms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $kode_materials = KodeMaterial::all();
    return view('bpm.create', compact('kode_materials'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_proyek' => 'required|string',
            'kode_material' => 'required|exists:kode_materials,kode_material',
            'jumlah_bpm' => 'required|integer',
            'satuan' => 'required|in:pcs,kg,set',
            'tgl_permintaan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Bpm::create($data);
        return redirect()->route('bpm.index')->with('success', 'BPM created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bpm $bpm)
    {
        return view('bpms.show', compact('bpm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Bpm $bpm)
{     
    $kode_materials = KodeMaterial::all();
    return view('bpm.edit', compact('bpm', 'kode_materials'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bpm $bpm)
    {
        $data = $request->validate([
            'order_proyek' => 'required|string',
            'kode_material' => 'required|exists:kode_materials,kode_material', // validate if kode_material exists
            'jumlah_bpm' => 'required|integer',
            'satuan' => 'required|in:pcs,kg,set',
            'tgl_permintaan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

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
}
