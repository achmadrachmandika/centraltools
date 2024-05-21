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
    // Mengambil semua data stok material
    $stokMaterials = Material::all(); 

    // Mengambil daftar status yang unik dari material
    $daftarStatus = Material::select('status')
        ->distinct()
        ->pluck('status')
        ->toArray();

    // Menetapkan queryStatus sebagai array kosong karena tidak ada filter yang aktif
    $queryStatus = [];

    // Mengembalikan view 'material.index' dengan data yang diperlukan
    return view('material.index', compact('stokMaterials', 'daftarStatus', 'queryStatus')); 
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
            // 'jumlah' => 'required|string',
            'satuan' => 'required|string',
            'lokasi' => 'required|string',
            'status' => 'required|string',

    ]);

    $stokMaterial = Material::where('kode_material', $id)->firstOrFail();
    $stokMaterial->update($data);

    return redirect()->route('stok_material.index')->with('success', 'stok Material updated successfully.');
}

public function filterStatus(Request $request)
{
    $daftarStatus = Material::select('status')
        ->distinct()
        ->pluck('status')
        ->toArray();

    // Dapatkan nilai dari input 'status'
    $queryStatus = $request->input('status');
    
    // Jika tidak ada status yang dipilih, atur $queryStatus menjadi array kosong
    if ($queryStatus === null) {
        $queryStatus = [];
    }

    // Filter stokMaterials berdasarkan status yang dipilih
    if (empty($queryStatus)) {
        $stokMaterials = Material::orderBy('created_at', 'desc')->get();
    } else {
        $stokMaterials = Material::whereIn('status', $queryStatus)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    return view('material.index', compact('stokMaterials', 'daftarStatus', 'queryStatus'));
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stokMaterial = Material::findOrFail($id);
        $kode_material = $stokMaterial->kode_material;
        $stokMaterial->delete();
        return redirect()->route('stok_material.index')->with('success', 'Stok Material '.$kode_material. ' deleted successfully.');
    }
}
