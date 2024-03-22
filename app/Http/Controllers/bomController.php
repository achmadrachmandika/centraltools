<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bom; // Sesuaikan dengan model yang benar
use App\Models\Material; // Sesuaikan dengan model yang benar

class BomController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
        public function index()
    {
        // Ambil data BOM dari database
        $boms = Bom::all();

        // Tampilkan data dalam view
        return view('bom.index', compact('boms'));
    }

    public function create()
    {
            $kode_materials = Material::all();
        return view('bom.create', compact('kode_materials')); // Sesuaikan dengan view yang benar
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{   
    $validated = $request->validate([
        'project' => 'nullable|string',
        'tgl_permintaan' => 'required|date',
        // Validasi untuk material dapat ditambahkan sesuai kebutuhan
    ]);

    // Mengumpulkan data yang diperlukan untuk disimpan
    $data = [
        'project' => $validated['project'],
        'tgl_permintaan' => $validated['tgl_permintaan'],
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
    Bom::create($data);

    return redirect()->route('bom.index')->with('success', 'BOM created successfully.');
}

    // Metode lain seperti show, edit, update, destroy, dll. sesuai kebutuhan Anda

     public function searchCodeMaterial(Request $request)
        {       
                if ($request->get('query')) {
                        $query = $request->get('query');
                        $data = DB::table('spareparts')
                            ->where('kode_material', 'LIKE', "%{$query}%")
                            ->get(); 
                            
                        $output = '<ul class="dropdown-menu" style="display:block; position:absolute;; max-height: 120px; overflow-y: auto;">';
                    
                        foreach ($data as $row) {
                                $output .= '
                                <a href="#" style="text-decoration:none; color:black;">
                                    <li data-satuan="' . $row->satuan . '" data-nama="' . $row->nama_material . '" data-spek="' . $row->spek_material . '"  style="background-color: white; list-style-type: none; cursor: pointer; padding-left:10px" onmouseover="this.style.backgroundColor=\'grey\'" onmouseout="this.style.backgroundColor=\'initial\'">'
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
