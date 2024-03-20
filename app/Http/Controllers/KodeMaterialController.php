<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KodeMaterial;

class KodeMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{   
    $kodeMaterials = KodeMaterial::all(); // Mengubah $kodeMaterials menjadi $kode_materials
    // dd($kodeMaterials);
    return view('kode_material.index', compact('kodeMaterials')); // Mengirimkan data ke view
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kode_material.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_material' => 'required|string|',
            'spek' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        KodeMaterial::create($data);
        return redirect()->route('kode_material.index')->with('success', 'Kode Material created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $kodeMaterials = KodeMaterial::all();
        return view('kode_material.show', compact('kodeMaterials'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kodeMaterial = KodeMaterial::findOrFail($id);
        return view('kode_material.edit', compact('kodeMaterial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    
    $data = $request->validate([
        'spek' => 'required|string',
        'keterangan' => 'nullable|string',
    ]);

    $kodeMaterial = KodeMaterial::where('kode_material', $id)->firstOrFail();
    $kodeMaterial->update($data);

    return redirect()->route('kode_material.index')->with('success', 'Kode Material updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kodeMaterial = KodeMaterial::findOrFail($id);
        $kodeMaterial->delete();
        return redirect()->route('kode_material.index')->with('success', 'Kode Material deleted successfully.');
    }
}
