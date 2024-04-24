<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\project;

class stokMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{   
    $stokMaterials = Material::all(); // Mengubah $stokMaterial menjadi $stok_material
    $daftar_projects = project::all();
    // dd($stokMaterial);
    return view('material.index', compact('stokMaterials', 'daftar_projects')); // Mengirimkan data ke view
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $daftar_projects = project::all();
        return view('material.create', compact('daftar_projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_material' => 'required|string',
            'nama' => 'required|string',
            'spek' => 'required|string',
            'jumlah' => 'required|string',
            'satuan' => 'required|string',
            'lokasi' => 'required|string',
              'project'=>'required|string',
            'status' => 'required|string',
        ]);

        Material::create($data);
        return redirect()->route('stok_material.index')->with('success', 'stok Material created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $stokMaterial = Material::all();
        return view('material.show', compact('stokMaterial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stokMaterial = Material::findOrFail($id);
        return view('material.edit', compact('stokMaterial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    
    $data = $request->validate([
        'kode_material' => 'required|string',
            'nama' => 'required|string',
            'spek' => 'required|string',
            'jumlah' => 'required|string',
            'satuan' => 'required|string',
            'lokasi' => 'required|string',
            'project' => 'required|string',
            'status' => 'required|string',

    ]);

    $stokMaterial = Material::where('kode_material', $id)->firstOrFail();
    $stokMaterial->update($data);

    return redirect()->route('stok_material.index')->with('success', 'stok Material updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stokMaterial = Material::findOrFail($id);
        $stokMaterial->delete();
        return redirect()->route('material.index')->with('success', 'stok Material deleted successfully.');
    }
}
