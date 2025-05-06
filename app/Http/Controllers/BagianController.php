<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bagian;
use App\Models\project;
use Yajra\DataTables\Facades\DataTables;

class BagianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $bagians = Bagian::with('materials')->get(); // eager load relasi
    // dd($bagians);
    return view('bagian.index', compact('bagians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $bagians = Bagian::all();
         $daftar_projects = project::all();
    return view('bagian.create', compact('bagians', 'daftar_projects'));
}


public function getData(Request $request)
{
    // return view('auth.login');
    $data = Bagian::select(['id', 'nama_bagian', 'lokasi']);
    // dd($data);
    // $data = Bagian::all();

    // return response()->json(['data' => $data]);
    
    return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
}








    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
          $validated = $request->validate([
        'nama_bagian' => 'required|string',
        'lokasi' => 'required|string',
    ]);

    Bagian::create([
        'nama_bagian' => $validated['nama_bagian'],
        'lokasi' => $validated['lokasi'],
    ]);

    return redirect()->route('bagian.index')->with('success', 'Bagian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    // Temukan data bagian berdasarkan ID
    $bagian = Bagian::findOrFail($id);
    
    // Hapus data bagian
    $bagian->delete();

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('bagian.index')->with('success', 'Bagian berhasil dihapus.');
}

}
