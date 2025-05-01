<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Models\project_material;
use App\Models\ProjectMaterialLoan;
use App\Models\ProjectMaterialLoanDetail;
use Illuminate\Http\Request;

class ProjectMaterialLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = ProjectMaterialLoan::with(['peminjam', 'pemilik'])->latest()->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $projects = Project::all();
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
    public function getByProject($projectId)
    {
        // Ambil data dengan relasi material
        $materials = project_material::with('material')
            ->where('project_id', $projectId)
            ->where('jumlah', '>', 0)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'jumlah' => $item->jumlah,
                    'material' => [
                        'nama_material' => $item->material->nama_material,
                    ]
                ];
            });

        // Mengembalikan data dalam format JSON
        return response()->json($materials);
    }

    /**
     * Store the loan request.
     */
    public function store(Request $request)
    {
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
                if ($projectMaterial) {
                    $projectMaterial->jumlah -= $jumlah_pinjam;
                    $projectMaterial->save();
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

        foreach ($loan->details as $detail) {
            $pm = $detail->projectMaterial;
            $pm->jumlah += $detail->jumlah;
            $pm->save();
        }

        $loan->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => now(),
        ]);

        return redirect()->back()->with('success', 'Material berhasil dikembalikan.');
    }
}
