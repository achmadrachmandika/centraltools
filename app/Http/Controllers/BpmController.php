<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bpm;
use App\Models\Material;
use App\Models\project;
use Illuminate\Support\Facades\DB; 


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
        $kode_materials = Material::all();
        $daftar_projects = project::all();
        return view('bpm.create', compact('kode_materials','daftar_projects'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
        'project'=>'required|string',
        'tgl_permintaan'=>'required|string',
        'status' => 'required|string|in:diterima,diserahkan',
        ]);

        $data= [
        'project'=> $validated['project'],
'tgl_permintaan'=> $validated['tgl_permintaan'],
'status' => $validated['status'],
'nama_material_1'=> $request->nama_material_1 ,
'kode_material_1'=> $request->kode_material_1,
'spek_material_1'=> $request->spek_material_1,
'jumlah_material_1'=> $request->jumlah_material_1,
'satuan_material_1'=> $request->satuan_material_1,
'nama_material_2'=> $request->nama_material_2 ,
'kode_material_2'=> $request->kode_material_2,
'spek_material_2'=> $request->spek_material_2,
'jumlah_material_2'=> $request->jumlah_material_2,
'satuan_material_2'=> $request->satuan_material_2,
'nama_material_3'=> $request->nama_material_3 ,
'kode_material_3'=> $request->kode_material_3,
'spek_material_3'=> $request->spek_material_3,
'jumlah_material_3'=> $request->jumlah_material_3,
'satuan_material_3'=> $request->satuan_material_3,
'nama_material_4'=> $request->nama_material_4 ,
'kode_material_4'=> $request->kode_material_4,
'spek_material_4'=> $request->spek_material_4,
'jumlah_material_4'=> $request->jumlah_material_4,
'satuan_material_4'=> $request->satuan_material_4,
'nama_material_5'=> $request->nama_material_5 ,
'kode_material_5'=> $request->kode_material_5,
'spek_material_5'=> $request->spek_material_5,
'jumlah_material_5'=> $request->jumlah_material_5,
'satuan_material_5'=> $request->satuan_material_5,
'nama_material_6'=> $request->nama_material_6 ,
'kode_material_6'=> $request->kode_material_6,
'spek_material_6'=> $request->spek_material_6,
'jumlah_material_6'=> $request->jumlah_material_6,
'satuan_material_6'=> $request->satuan_material_6,
'nama_material_7'=> $request->nama_material_7 ,
'kode_material_7'=> $request->kode_material_7,
'spek_material_7'=> $request->spek_material_7,
'jumlah_material_7'=> $request->jumlah_material_7,
'satuan_material_7'=> $request->satuan_material_7,
'nama_material_8'=> $request->nama_material_8 ,
'kode_material_8'=> $request->kode_material_8,
'spek_material_8'=> $request->spek_material_8,
'jumlah_material_8'=> $request->jumlah_material_8,
'satuan_material_8'=> $request->satuan_material_8,
'nama_material_9'=> $request->nama_material_9 ,
'kode_material_9'=> $request->kode_material_9,
'spek_material_9'=> $request->spek_material_9,
'jumlah_material_9'=> $request->jumlah_material_9,
'satuan_material_9'=> $request->satuan_material_9,
'nama_material_10'=> $request->nama_material_10,
'kode_material_10'=> $request->kode_material_10,
'spek_material_10'=> $request->spek_material_10,
'jumlah_material_10'=> $request->jumlah_material_10,
'satuan_material_10'=> $request->satuan_material_10,

        ];

            // Jika status "diterima", kurangi stok material sesuai dengan jumlah yang diminta
    if ($validated['status'] === 'diterima') {
        for ($i = 1; $i <= 10; $i++) {
            $kode_material = $request->input("kode_material_$i");
            $jumlah_material = $request->input("jumlah_material_$i");

            if ($kode_material && $jumlah_material) {
                // Cari material berdasarkan kode
                $material = Material::where('kode_material',$kode_material)->first();

                if ($material) {
                    // Kurangi stok material
                    $material->jumlah += $jumlah_material;
                    $material->save();
                }
            }
        }
    }
// dd($data);
        Bpm::create($data);
        return redirect()->route('bpm.index')->with('success', 'BPM created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bpm = Bpm::where('nomor_bpm', $id)->first();
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
        'project' => 'required|string',
        'tgl_permintaan' => 'required|string',
        'status' => 'required|string|in:diterima,diserahkan', // Validasi status
    ]);

    $data = [
        'project' => $validated['project'],
        'tgl_permintaan' => $validated['tgl_permintaan'],
        'status' => $validated['status'], // Menambahkan status ke dalam data
    ];

    // Jika status "diterima", tambahkan jumlah material ke stok
    if ($validated['status'] === 'diterima') {
        for ($i = 1; $i <= 10; $i++) {
            $kode_material = $request->input("kode_material_$i");
            $jumlah_material = $request->input("jumlah_material_$i");

            if ($kode_material && $jumlah_material) {
                // Cari material berdasarkan kode
                $material = Material::where('kode_material', $kode_material)->first();

                if ($material) {
                    // Tambahkan stok material
                    $material->jumlah += $jumlah_material;
                    $material->save();
                }
            }
        }
    }

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

    public function searchCodeMaterial(Request $request)
{       
    if ($request->get('query')) {
        $query = $request->get('query');
        $data = Material::where('kode_material', 'LIKE', "%{$query}%")->get(); 
        
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
