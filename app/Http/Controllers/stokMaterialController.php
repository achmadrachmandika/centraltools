<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;  // Import DB facade
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Material;
use App\Models\project;
use App\Models\project_material;


class stokMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexFabrikasi()
    {
        // Menghapus session dengan kunci 'last_segment'
        Session::forget('last_segment');

        // Mendapatkan bagian dari URL setelah karakter terakhir '/'
        $lastSegment = Str::afterLast(url()->current(), '/');

        // Simpan nilai $lastSegment ke dalam session
        Session::put('last_segment', $lastSegment);

        // Mengambil semua data stok material
        $stokMaterials = Material::where('lokasi', 'fabrikasi')->get();

        // Mengambil semua records dari project_material yang berkaitan dengan stok materials
        $materialCodes = $stokMaterials->pluck('kode_material')->toArray();
        $materials = project_material::whereIn('kode_material', $materialCodes)
            ->select('kode_material', 'kode_project', 'jumlah')
            ->get();

        // Mengambil semua project names yang terkait
        $projectIds = $materials->pluck('kode_project')->toArray();
        $projects = project::whereIn('id', $projectIds)->pluck('nama_project', 'id');


        $tabelProjects = project::pluck('nama_project')->toArray();

        // Menambahkan data project material ke stokMaterials
        foreach ($stokMaterials as $stok) {
            // Inisialisasi setiap project dengan nilai 0
            foreach ($tabelProjects as $project) {
                $stok->{"material_{$project}"} = 0;
            }

            foreach ($materials as $material) {
                if ($material->kode_material == $stok->kode_material) {
                    $projectName = $projects[$material->kode_project] ?? 'Unknown Project';
                    if (in_array($projectName, $tabelProjects)) {
                        $stok->{"material_{$projectName}"} = $material->jumlah;
                    }
                }
            }
        }

        // dd($tabelProject, $stokMaterials);

        // Mengambil daftar status yang unik dari material
        $daftarStatus = Material::where('lokasi', 'fabrikasi')
            ->distinct()
            ->pluck('status')
            ->toArray();

        // Menetapkan queryStatus sebagai array kosong karena tidak ada filter yang aktif
        $queryStatus = [];

    //    dd($stokMaterials->toArray());




        // Mengembalikan view 'material.index-fabrikasi' dengan data yang diperlukan
        return view('material.index-fabrikasi', compact('stokMaterials', 'daftarStatus', 'queryStatus', 'tabelProjects'));
    }

//  public function indexFabrikasi(Request $request)
// {
//     // Hapus session 'last_segment' dan perbarui dengan segment terakhir dari URL
//     Session::forget('last_segment');
//     $lastSegment = Str::afterLast(url()->current(), '/');
//     Session::put('last_segment', $lastSegment);

//     // Ambil semua proyek agar tetap tersedia di tampilan
//     $tabelProjects = project::pluck('nama_project')->toArray();

//     // Ambil daftar status unik dari material
//     $daftarStatus = Material::where('lokasi', 'fabrikasi')->distinct()->pluck('status')->toArray();
//     $queryStatus = [];

//     // Ambil semua stok materials, agar tetap tersedia untuk tampilan
//     $stokMaterials = Material::where('lokasi', 'fabrikasi')->get();

//     // Jika request berasal dari DataTables (Ajax)
//     if ($request->ajax()) {
//         // Ambil kode_material untuk cross-reference dengan project_material
//         $materialCodes = $stokMaterials->pluck('kode_material')->toArray();
//         $materials = project_material::whereIn('kode_material', $materialCodes)
//             ->select('kode_material', 'kode_project', 'jumlah')
//             ->get();

//         // Ambil project names berdasarkan kode_project
//         $projectIds = $materials->pluck('kode_project')->toArray();
//         $projects = project::whereIn('id', $projectIds)->pluck('nama_project', 'id');

//         // Proses pengisian data proyek ke stokMaterials
//         foreach ($stokMaterials as $stok) {
//             foreach ($tabelProjects as $project) {
//                 $stok->{"material_{$project}"} = 0;
//             }
//             foreach ($materials as $material) {
//                 if ($material->kode_material == $stok->kode_material) {
//                     $projectName = $projects[$material->kode_project] ?? 'Unknown Project';
//                     if (in_array($projectName, $tabelProjects)) {
//                         $stok->{"material_{$projectName}"} = $material->jumlah;
//                     }
//                 }
//             }
//         }

//         return DataTables::of($stokMaterials)
//             ->addIndexColumn()
//             ->addColumn('action', function ($row) {
//                 return '<a href="#" class="btn btn-sm btn-primary">Edit</a>';
//             })
//             ->rawColumns(['action'])
//             ->make(true);
//     }

//     // Kembalikan view dengan variabel yang tersedia
//     return view('material.index-fabrikasi', compact('stokMaterials', 'daftarStatus', 'queryStatus', 'tabelProjects'));
// }




    public function indexFinishing()
    {
        // Menghapus session dengan kunci 'last_segment'
        Session::forget('last_segment');

        // Mendapatkan bagian dari URL setelah karakter terakhir '/'
        $lastSegment = Str::afterLast(url()->current(), '/');

        // Simpan nilai $lastSegment ke dalam session
        Session::put('last_segment', $lastSegment);

        // Mengambil semua data stok material
        $stokMaterials = Material::where('lokasi', 'finishing')->paginate(200);

        // Mengambil semua records dari project_material yang berkaitan dengan stok materials
        $materialCodes = $stokMaterials->pluck('kode_material')->toArray();
        $materials = project_material::whereIn('kode_material', $materialCodes)
            ->select('kode_material', 'kode_project', 'jumlah')
            ->get();

        // Mengambil semua project names yang terkait
        $projectIds = $materials->pluck('kode_project')->toArray();
        $projects = project::whereIn('id', $projectIds)->pluck('nama_project', 'id');

        $tabelProjects = project::pluck('nama_project')->toArray();

        // Menambahkan data project material ke stokMaterials
        foreach ($stokMaterials as $stok) {
            // Inisialisasi setiap project dengan nilai 0
            foreach ($tabelProjects as $project) {
                $stok->{"material_{$project}"} = 0;
            }

            foreach ($materials as $material) {
                if ($material->kode_material == $stok->kode_material) {
                    $projectName = $projects[$material->kode_project] ?? 'Unknown Project';
                    if (in_array($projectName, $tabelProjects)) {
                        $stok->{"material_{$projectName}"} = $material->jumlah;
                    }
                }
            }
        }

        // Mengambil daftar status yang unik dari material
        $daftarStatus = Material::where('lokasi', 'finishing')
            ->distinct()
            ->pluck('status')
            ->toArray();

        // Menetapkan queryStatus sebagai array kosong karena tidak ada filter yang aktif
        $queryStatus = [];

        // Mengembalikan view 'material.index-finishing' dengan data yang diperlukan
        return view('material.index-finishing', compact('stokMaterials', 'daftarStatus', 'queryStatus', 'tabelProjects'));
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
        // Validasi input
        $validatedData = $request->validate([
            'kode_material' => 'required|string|unique:materials',
            'nama' => 'required|string',
            'spek' => 'required|string',
            'project' => 'required|array',
            'lokasi' => 'required|string',
            'satuan' => 'required|string',
            'status' => 'required|string',
        ]);



         if($request->hasFile('foto')){
            $request->validate([
                'foto' => 'mimes:jpg,png|max:2048'
            ]);

            $imageName = $validatedData['kode_material'].'.'.$request->foto->extension();

            // Store the image and get the path
            $request->foto->storeAs('material', $imageName);
        }
        else{
            $imageName = NULL;
        }
         

        // Inisialisasi data material
        $data = [
            'kode_material' => $validatedData['kode_material'],
            'nama' => $validatedData['nama'],
            'spek' => $validatedData['spek'],
            'jumlah' => 0,
            'satuan' => $validatedData['satuan'],
            'project' => implode(',', $validatedData['project']),
            'lokasi' => $validatedData['lokasi'],
            'status' => $validatedData['status'],
            'foto' => $imageName
        ];


        // Menggunakan transaksi database untuk memastikan konsistensi data
        DB::transaction(function () use ($data, $request, $validatedData) {
            // Buat material baru
            Material::create($data);

            // Inisialisasi total jumlah
            $totalJumlah = 0;

            // Iterasi melalui setiap proyek
            foreach ($validatedData['project'] as $project) {
                // Validasi jumlah untuk setiap proyek
                $jumlah = $request->validate([
                    "jumlah_$project" => 'required|integer',
                ])["jumlah_$project"];

                // Tambahkan jumlah ke total
                $totalJumlah += $jumlah;

                // Buat data untuk project_material
                $projectMaterialData = [
                    'kode_material' => $validatedData['kode_material'],
                    'kode_project' => $project,
                    'jumlah' => $jumlah,
                ];

                // Simpan data project_material
                project_material::create($projectMaterialData);
            }

            // Update total jumlah di tabel materials
            Material::where('kode_material', $validatedData['kode_material'])->update(['jumlah' => $totalJumlah]);
        });

        // Redirect dengan pesan sukses
        return redirect()->route('stok_material_' . $data['lokasi'] . '.index')->with('success', 'Stok Material created successfully.');
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

        $materialProject = $stokMaterial->project; // String "612,retrofit,kci"
        $materialProjectArray = explode(',', $materialProject); // Mengubah string menjadi array
        $daftar_projects = Project::get(); // Pastikan model Project disebut dengan benar
        $hiddenProjectAwal = $materialProjectArray;

        return view('material.edit', compact('stokMaterial', 'daftar_projects', 'materialProjectArray', 'hiddenProjectAwal'));
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
            'project' => 'required|array',
            // 'jumlah' => 'required|string',
            'satuan' => 'required|string',
            'lokasi' => 'required|string',
            'status' => 'required|string',

        ]);

        $projectAwal = json_decode($request->input('hidden_project_awal'), true);

        // dd($projectAwal, $data['project']);

        if ($data['project'] !== $projectAwal) {

            // Inisialisasi total jumlah
            $totalJumlah = 0;

            // Iterasi melalui setiap proyek
            foreach ($data['project'] as $project) {

                if (!in_array($project, $projectAwal)) {

                    // Validasi jumlah untuk setiap proyek
                    $jumlah = $request->validate([
                        "jumlah_$project" => 'required|integer',
                    ])["jumlah_$project"];

                    // Tambahkan jumlah ke total
                    $totalJumlah += $jumlah;

                    // Buat data untuk project_material
                    $projectMaterialData = [
                        'kode_material' => $data['kode_material'],
                        'kode_project' => $project,
                        'jumlah' => $jumlah,
                    ];
                    project_material::create($projectMaterialData);

                    $jumlahAkhir = project_material::where('kode_material', $data['kode_material'])->pluck('jumlah')->sum();

                    Material::where('kode_material', $data['kode_material'])->update(['jumlah' => $jumlahAkhir]);
                }
            }
        }

        

        // Mengubah array project menjadi string yang dipisahkan oleh koma
        $data['project'] = implode(', ', $data['project']);

        $stokMaterial = Material::where('kode_material', $id)->firstOrFail();

        // Handle image update if a new image is uploaded
    if ($request->hasFile('foto')) {
        // Validate the foto
        $request->validate([
            'foto' => 'image|file|max:2048',
        ]);

        $imageName = $id.'.'.$request->foto->extension();  


        $data['foto'] = $imageName;

            // Get the path to the foto file
            $fotoPath = 'material/' . $stokMaterial->foto;
            if ($stokMaterial->foto && Storage::exists($fotoPath)) {
                Storage::delete($fotoPath);
            }
            $request->foto->storeAs('material', $imageName);
        } else {
            $imageName = $stokMaterial->foto;
        }



        $stokMaterial->update($data);

        return redirect()->route('stok_material_' . $data['lokasi'] . '.index')->with('success', 'stok Material updated successfully.');
    }

    public function filterStatus(Request $request)
{
    // Mengambil nilai session 'last_segment'
    $lastSegment = Session::get('last_segment');

    // Mengambil daftar status yang unik dari material
    $daftarStatus = Material::where('lokasi', $lastSegment)
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
        $stokMaterials = Material::where('lokasi', $lastSegment)->orderBy('created_at', 'desc')->get();
    } else {
        $stokMaterials = Material::where('lokasi', $lastSegment)->whereIn('status', $queryStatus)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Mengambil semua records dari project_material yang berkaitan dengan stok materials
    $materialCodes = $stokMaterials->pluck('kode_material')->toArray();
    $materials = project_material::whereIn('kode_material', $materialCodes)
        ->select('kode_material', 'kode_project', 'jumlah')
        ->get();

    // Mengambil semua project names yang terkait
    $projectIds = $materials->pluck('kode_project')->toArray();
    $projects = project::whereIn('id', $projectIds)->pluck('nama_project', 'id');

    // Define $tabelProjects
    $tabelProjects = project::pluck('nama_project')->toArray();

    // Menambahkan data project material ke stokMaterials
    foreach ($stokMaterials as $stok) {
        // Inisialisasi setiap project dengan nilai 0
        foreach ($tabelProjects as $project) {
            $stok->{"material_{$project}"} = 0;
        }

        foreach ($materials as $material) {
            if ($material->kode_material == $stok->kode_material) {
                $projectName = $projects[$material->kode_project] ?? 'Unknown Project';
                if (in_array($projectName, $tabelProjects)) {
                    $stok->{"material_{$projectName}"} = $material->jumlah;
                }
            }
        }
    }

    return view('material.index-' . $lastSegment, compact('stokMaterials', 'daftarStatus', 'queryStatus', 'tabelProjects'));
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stokMaterial = Material::findOrFail($id);
        $kode_material = $stokMaterial->kode_material;

        $stokMaterial->delete();
        return redirect()->back()->with('success', 'Stok Material ' . $kode_material . ' deleted successfully.');
    }
}
