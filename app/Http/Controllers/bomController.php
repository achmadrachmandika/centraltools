<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bom; // Sesuaikan dengan model yang benar
use App\Models\Material; // Sesuaikan dengan model yang benar
use App\Models\project;
use App\Models\sparepartBom;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
            $daftar_projects = project::all();
            $kode_materials = Material::all();
        return view('bom.create', compact('kode_materials', 'daftar_projects')); // Sesuaikan dengan view yang benar
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{   
        $validated = $request->validate([
            'project' => 'required|string',
            'tgl_permintaan' => 'required|date',
            'keterangan' => '',
            'excel_bom' => 'required|mimes:xlsx,xls|max:2048'
        ]);

    // Mengumpulkan data yang diperlukan untuk disimpan
    $data = [
        'project' => $validated['project'],
        'tgl_permintaan' => $validated['tgl_permintaan'],
        'keterangan' => $validated['keterangan']
    ]; // Pastikan untuk menutup kurung kurawal di sini

    $newBom = bom::create($data);

    // Menggunakan ID dari model yang baru saja dibuat
    $newBomId = $newBom->nomor_bom;

    try {
        $file = $request->file('excel_bom');
        $reader = IOFactory::createReaderForFile($file);

        // Load file Excel
        $spreadsheet = $reader->load($file);
        // Mendapatkan jumlah baris yang ingin dilewati (misalnya 4 baris pertama)
        $skipRows = 2;
        // Membuat array untuk menyimpan data yang akan diimpor
        $data = [];
        // Loop melalui setiap baris dimulai dari baris ke-1 (indeks 0)
        foreach ($spreadsheet->getActiveSheet()->getRowIterator($skipRows + 1) as $row) {
            // Mendapatkan nilai sel untuk setiap kolom pada baris saat ini
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getFormattedValue(); // Menggunakan getFormattedValue untuk mengambil nilai yang ditampilkan di Excel
            }
            // Menambahkan array rowData ke dalam array data
            $data[] = $rowData;
        }

        foreach ($data as $row) {
            $dataToInsert  = [
                'nomor_bom' => $newBomId,
                'no_material_pada_bom' => $newBomId . '00' . $row[0],
                'no' => $row[0],
                'kode_material' => $row[1],
                'desc_material' => $row[2],
                'spek_material' => $row[3],
                // Menggunakan intval() untuk mengonversi nilai ke integer
                'qty_fab' => intval($row[4]),
                'qty_fin' => intval($row[5]),
                'total_material' => intval($row[6]),
                'satuan_material' => $row[7],
                'keterangan' => $row[8],
                'revisi' => $row[9],
            ];

            sparepartBom::create($dataToInsert);
        }
        

        return redirect()->route('bom.index')->with('success', 'Data BOM berhasil diimpor.');
    } catch (\Exception $e) {
        return redirect()->route('bom.create')->with('error', 'Error dalam membaca file Excel, Silahkan cek apakah ada entry duplikat, atau format file tidak sesuai!');
    }

    return redirect()->route('bom.index')->with('success', 'BOM created successfully.');
}

    public function show($id)
    {
        $bom = Bom::where('nomor_bom', $id)->first();
        $materials = sparepartBom::where('nomor_bom', $id)->get();
        return view('bom.show', compact('bom','materials'));
    }

    
      public function edit(Bom $bom)
    {     
        $kode_materials = Material::all();
        $daftar_projects = project::all();
        $materials = sparepartBom::where('nomor_bom', $bom->nomor_bom)->get();
        return view('bom.edit', compact('bom', 'kode_materials', 'daftar_projects','materials'));
    }
      public function update(Request $request, Bom $bom)
{
    $validated = $request->validate([
        'project' => 'required|string',
        'tgl_permintaan' => 'required|string',
        'keterangan' => ''
    ]);

    // Perbarui atribut Bom dengan data yang divalidasi dari request
    $bom->project = $validated['project'];
    $bom->tgl_permintaan = $validated['tgl_permintaan'];
    $bom->keterangan = $validated['keterangan'];

    // Simpan perubahan ke database
    $bom->save();

    return redirect()->route('bom.index')->with('success', 'BOM updated successfully.');
}


      public function destroy(Bom $bom)
    {
        $bom->delete();
        return redirect()->route('bom.index')->with('success', 'BOM deleted successfully.');
    }

    public function edit_material($material)
    {    
        $kode_materials = Material::all();
        $daftar_projects = project::all();
        $materials = sparepartBom::where('no_material_pada_bom', $material)->first();
        return view('bom.edit-material', compact('kode_materials', 'daftar_projects','materials'));
    }
      public function update_material(Request $request, $material)
    {
        $validated = $request->validate([
            'kode_material'=>'required|string',
            'desc_material'=>'required|string',
            'spek_material'=>'required|string',
            'qty_fab'=>'required|integer',
            'qty_fin'=>'required|integer',
            'satuan' => 'required'
            ]);
    
            $data= [
                'kode_material'=> $validated['kode_material'],
                'desc_material'=> $validated['desc_material'],
                'spek_material'=> $validated['spek_material'],
                'qty_fab'=> $validated['qty_fab'],
                'qty_fin'=> $validated['qty_fin'],
                'total_material' => $validated['qty_fab'] + $validated['qty_fin'],
                'satuan' => $validated['satuan'],
            ];

            $materials = sparepartBom::where('no_material_pada_bom', $material)->first();
        $materials->update($data);
        return redirect()->route('bom.show', $materials->nomor_bom)->with('success', 'Material updated successfully.');
    }

      public function destroy_material($material)
    {   
        $no_bom = sparepartBom::where('no_material_pada_bom', $material)->first();
        $materials = sparepartBom::where('no_material_pada_bom', $material)->delete();
        return redirect()->route('bom.show', $no_bom->nomor_bom)->with('success', 'BOM deleted successfully.');
    }

    // Metode lain seperti show, edit, update, destroy, dll. sesuai kebutuhan Anda

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
