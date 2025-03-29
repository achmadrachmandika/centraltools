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
use Illuminate\Validation\Rule;



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
   $materialIds = $stokMaterials->pluck('id')->toArray(); // Gunakan 'id' sebagai primary key
$materials = project_material::whereIn('material_id', $materialIds)
    ->select('material_id', 'kode_project', 'jumlah')
    ->get();

    // Mengambil semua project names yang terkait
    $projectIds = $materials->pluck('kode_project')->toArray();
    $projects = project::whereIn('id', $projectIds)->pluck('nama_project', 'id');

    $tabelProjects = project::pluck('nama_project')->toArray();

    // Menambahkan data project material ke stokMaterials
   foreach ($stokMaterials as $stok) {
    // Inisialisasi setiap project dengan nilai 0
    foreach ($tabelProjects as $project) {
        $stok->{"material_{$project}"} = 0; // Tambahkan kolom untuk proyek
    }

    // Mengupdate stok material dengan jumlah yang sesuai dari project_material
    foreach ($materials as $material) {
        if ($material->material_id == $stok->id) { // Gunakan 'id' sebagai primary key
            // Cek jika project terkait, kemudian tambahkan jumlah
            $projectName = $projects[$material->kode_project] ?? null;
            if ($projectName !== null && in_array($projectName, $tabelProjects)) {
                $stok->{"material_$projectName"} += $material->jumlah; // Tambahkan jumlah
            }
        }
    }
}

// Debugging hasil akhirnya
// dd($stokMaterials);

    // Mengambil daftar status yang unik dari material
    $daftarStatus = Material::where('lokasi', 'fabrikasi')
        ->distinct()
        ->pluck('status')
        ->toArray();

    // Menetapkan queryStatus sebagai array kosong karena tidak ada filter yang aktif
    $queryStatus = [];

    // Mengembalikan view 'material.index-fabrikasi' dengan data yang diperlukan
    return view('material.index-fabrikasi', compact('stokMaterials', 'daftarStatus', 'queryStatus', 'tabelProjects'));
}










 public function indexFinishing()
{
    // Menghapus session dengan kunci 'last_segment'
    Session::forget('last_segment');

    // Mendapatkan bagian dari URL setelah karakter terakhir '/'
    $lastSegment = Str::afterLast(url()->current(), '/');
    Session::put('last_segment', $lastSegment);

    // Mengambil semua data stok material di lokasi "finishing"
    $stokMaterials = Material::where('lokasi', 'finishing')->get();

    // Mengambil ID dari semua stok material untuk pencarian project_material
    $materialIds = $stokMaterials->pluck('id')->toArray();

    // Mengambil data project_material berdasarkan material_id
    $materials = project_material::whereIn('material_id', $materialIds)
        ->select('material_id', 'kode_project', 'jumlah')
        ->get();

    // Mengambil semua project names yang terkait
    $projectIds = $materials->pluck('kode_project')->toArray();
    $projects = Project::whereIn('id', $projectIds)->pluck('nama_project', 'id');

    // Mengambil daftar nama proyek untuk inisialisasi kolom
    $tabelProjects = Project::pluck('nama_project')->toArray();

    // Menambahkan data project material ke stokMaterials
    foreach ($stokMaterials as $stok) {
        // Inisialisasi setiap proyek dengan nilai 0
        foreach ($tabelProjects as $project) {
            $stok->{"material_$project"} = 0; // Format nama kolom disamakan
        }

        foreach ($materials as $material) {
            if ($material->material_id == $stok->id) { // Gunakan ID sebagai primary key
                $projectName = $projects[$material->kode_project] ?? null;
                if ($projectName !== null && in_array($projectName, $tabelProjects)) {
                    $stok->{"material_$projectName"} += $material->jumlah; // Tambahkan jumlah
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

    // Mengembalikan view dengan data yang telah diproses
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

public function store(Request $request)
{   
    $validatedData = $request->validate([
        'kode_material' => [
            'required',
            Rule::unique('materials', 'kode_material')->where(function ($query) use ($request) {
                return $query->where('lokasi', $request->lokasi);
            })
        ],
        'nama' => 'required|string',
        'spek' => 'required|string',
        'project' => 'required|array',
        'lokasi' => 'required|string',
        'satuan' => 'required|string',
        'status' => 'required|string',
    ]);

    // Validasi & Simpan Foto jika ada
    $imageName = null;
    if ($request->hasFile('foto')) {
        $request->validate(['foto' => 'mimes:jpg,png|max:2048']);
        $imageName = $validatedData['kode_material'].'_'.$validatedData['lokasi'].'.'.$request->foto->extension();
        $request->foto->storeAs('material', $imageName);
    }

    // Gunakan transaksi untuk memastikan konsistensi data
    DB::transaction(function () use ($validatedData, $request, $imageName) {
        // Cek apakah material sudah ada
        $material = Material::where('kode_material', $validatedData['kode_material'])
            ->where('lokasi', $validatedData['lokasi'])
            ->first();

        // Jika belum ada, buat material baru
        if (!$material) {
            $material = Material::create([
                'kode_material' => $validatedData['kode_material'],
                'nama' => $validatedData['nama'],
                'spek' => $validatedData['spek'],
                'jumlah' => 0, // Jumlah awal 0, akan diperbarui nanti
                'satuan' => $validatedData['satuan'],
                'project' => implode(',', $validatedData['project']),
                'lokasi' => $validatedData['lokasi'],
                'status' => $validatedData['status'],
                'foto' => $imageName
            ]);
        }

        // Pastikan material_id yang digunakan adalah ID dari material yang dibuat atau ditemukan
        $materialId = $material->id;
        
        // Inisialisasi total jumlah
        $totalJumlah = (int) $material->jumlah;

        // Iterasi proyek dan update jumlah material
        foreach ($validatedData['project'] as $project) {
            // Validasi jumlah untuk masing-masing proyek
            $jumlahKey = "jumlah_$project";
            if ($request->has($jumlahKey) && is_numeric($request->$jumlahKey)) {
                $jumlah = (int) $request->$jumlahKey;
            } else {
                continue; // Skip jika jumlah tidak valid
            }

            // Tambahkan jumlah ke total
            $totalJumlah += $jumlah;

            // Periksa apakah project_material sudah ada
            $projectMaterial = project_material::where([
                'material_id' => $materialId,
                'kode_project' => $project,
            ])->first();

            if ($projectMaterial) {
                $projectMaterial->increment('jumlah', $jumlah);
            } else {
                project_material::create([
                    'material_id' => $materialId,
                    'kode_project' => $project,
                    'jumlah' => $jumlah,
                ]);
            }
        }

        // Update total jumlah material
        $material->update(['jumlah' => $totalJumlah]);
    });

    return redirect()->route('stok_material_' . $validatedData['lokasi'] . '.index')->with('success', 'Stok Material berhasil ditambahkan.');
}

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

        // Ambil material_id berdasarkan kode_material
        $material = Material::where('kode_material', $data['kode_material'])->first();
        if (!$material) {
            return back()->withErrors(['kode_material' => 'Material tidak ditemukan.']);
        }

        // Buat data untuk project_material
        $projectMaterialData = [
            'material_id' => $material->id, // Perbaikan: gunakan material_id
            'kode_project' => $project,
            'jumlah' => $jumlah,
        ];
        project_material::create($projectMaterialData);

        // Update jumlah total
        $jumlahAkhir = project_material::where('material_id', $material->id)->sum('jumlah');
        $material->update(['jumlah' => $jumlahAkhir]);
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




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    // Menemukan stok material berdasarkan id
    $stokMaterial = Material::findOrFail($id);

    // Menyimpan id untuk keperluan feedback setelah delete
    $materialId = $stokMaterial->id;

    // Menghapus stok material
    $stokMaterial->delete();

    // Mengarahkan kembali dengan pesan sukses
    return redirect()->back()->with('success', 'Stok Material ' . $materialId . ' deleted successfully.');
}


}
