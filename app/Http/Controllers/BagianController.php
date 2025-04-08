<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bagian;
use App\Models\project;

class BagianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $bagians = Bagian::with('materials')->get(); // eager load relasi
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
        //
    }
}
