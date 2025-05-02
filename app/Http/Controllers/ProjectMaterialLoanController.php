<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Models\project_material;
use App\Models\ProjectMaterialLoan;
use App\Models\ProjectMaterialLoanDetail;
use App\Models\Material;
use Illuminate\Http\Request;

class ProjectMaterialLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        // $loans = ProjectMaterialLoanDetail::with(['peminjam', 'pemilik','details'])->latest()->get();

        
        $loans = ProjectMaterialLoan::latest()->get();

        foreach ($loans as $loan) {
            $namaProject = ProjectMaterialLoan::where("id", $loan->id)->first();
            $loanDetail = ProjectMaterialLoanDetail::where("id", $loan->id)->first();


            $projectPeminjamId = $namaProject->project_peminjam_id;
            $projectPemilikId = $namaProject->project_pemilik_id;


            // Ambil nama_project saja dari tabel Project menggunakan pluck()
            $namaPeminjam = Project::where('id', $projectPeminjamId)->pluck('nama_project')->first();
            $namaPemilik = Project::where('id', $projectPemilikId)->pluck('nama_project')->first();
            $material = project_material::where('id', $loanDetail->project_material_id)->first();
            $namaMaterial = Material::where('id', $material->material_id)->first();

            // Assign nama_project ke $loan
            $loan->project_peminjam_name = $namaPeminjam;
            $loan->project_pemilik_name = $namaPemilik;
            $loan->jumlah = $loanDetail->jumlah;
            $loan->nama_material = $namaMaterial->nama;
        }

        // dd($loans);
        
       
    
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $projects = Project::all();
        // $projects = project_material::all();
        return view('loans.create', compact('projects'));
    }

    /**
     * Get materials based on project, location, and material code.
     */
  public function getMaterials(Request $request)
{
      $projectId = $request->get('project_id');
    $lokasi = $request->get('lokasi');

    if (!$projectId || !$lokasi) {
        return response()->json([], 200);
    }

    $materials = prject_material::with('material')
        ->where('project_id', $projectId)
        ->where('lokasi', $lokasi)
        ->where('jumlah', '>', 0)
        ->get();

    return response()->json($materials);
}



    /**
     * Get materials by project id.
     */
public function getByProject($projectId, Request $request)
{
    // $lokasi = $request->query('lokasi');
    // \Log::info("Menerima request untuk lokasi: $lokasi dan projectId: $projectId");

    // Ambil data dengan relasi material
    $materials = project_material::where('kode_project', $projectId)
        ->where('jumlah', '>', 0)
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'jumlah' => $item->jumlah,
                'material' => [
                    'nama_material' => $item->material->nama,
                    'id_material' => $item->material->id, // Menambahkan ID material jika diperlukan
                ]
            ];
        });

    // Log data yang dikembalikan
    \Log::info("Data yang dikembalikan:", $materials->toArray());

    // Kembalikan response JSON
    return response()->json($materials);
}




    /**
     * Store the loan request.
     */
   public function store(Request $request)
{
    // dd($request);
    $request->validate([
        'project_peminjam_id' => 'required|exists:projects,id',
        'project_pemilik_id' => 'required|exists:projects,id',
        'tanggal_pinjam' => 'required|date',
        'materials' => 'required|array',
    ]);

    

    // Simpan header peminjaman
    $loan = ProjectMaterialLoan::create([
        'project_peminjam_id' => $request->project_peminjam_id,
        'project_pemilik_id' => $request->project_pemilik_id,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'status' => 'dipinjam', // default status
    ]);

    // Simpan detail material
    foreach ($request->materials as $project_material_id => $jumlah_pinjam) {
        if ($jumlah_pinjam > 0) { // hanya simpan yang dipinjam
            ProjectMaterialLoanDetail::create([
                'loan_id' => $loan->id,
                'project_material_id' => $project_material_id,
                'jumlah' => $jumlah_pinjam,
            ]);

            // Update stok project material asal (kurangi jumlah)
            $projectMaterial = project_material::find($project_material_id);
           if ($projectMaterial && $projectMaterial->jumlah >= $jumlah_pinjam) {
                $projectMaterial->jumlah -= $jumlah_pinjam;
                $projectMaterial->save();

                // Update total stok di tabel materials setelah perubahan dalam project_material
                $totalStok = project_material::where('material_id', $project_material_id)->sum('jumlah');
                Material::where('id', $project_material_id)->update(['jumlah' => $totalStok]);

            } else {
            \Log::warning("Stok material tidak cukup untuk ProjectMaterial ID: $project_material_id");
            // Anda bisa menambahkan logika untuk menangani kasus stok tidak cukup
}

        }
    }

    return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil disimpan.');
}


    /**
     * Return the loaned materials.
     */
    public function returnLoan($id)
    {
        $loan = ProjectMaterialLoan::with('details.projectMaterial')->findOrFail($id);

        $material = ProjectMaterialLoanDetail::where("id" , $loan->id)->first();


        foreach ($loan->details as $detail) {
            $pm = $detail->projectMaterial;
            $pm->jumlah += $detail->jumlah;
            $pm->save();
        }

        $loan->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => now(),
        ]);

        // Update total stok di tabel materials setelah perubahan dalam project_material
                $totalStok = project_material::where('material_id', $material->project_material_id)->sum('jumlah');

                Material::where('id', $material->project_material_id)->update(['jumlah' => $totalStok]);

        return redirect()->back()->with('success', 'Material berhasil dikembalikan.');
    }
}
