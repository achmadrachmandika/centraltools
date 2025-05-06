<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Models\project_material;
use App\Models\ProjectMaterialLoan;
use App\Models\ProjectMaterialLoanDetail;
use App\Models\Material;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProjectMaterialLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {


        // $loans = ProjectMaterialLoanDetail::with(['peminjam', 'pemilik','details'])->latest()->get();

        
    //     $loans = ProjectMaterialLoan::latest()->get();

    //     foreach ($loans as $loan) {
    //         $namaProject = ProjectMaterialLoan::where("id", $loan->id)->get();
    //         $loanDetail = ProjectMaterialLoanDetail::where("id", $loan->id)->get();


    //         $projectPeminjamId = $namaProject->project_peminjam_id;
    //         $projectPemilikId = $namaProject->project_pemilik_id;


    //         // Ambil nama_project saja dari tabel Project menggunakan pluck()
    //         $namaPeminjam = Project::where('id', $projectPeminjamId)->pluck('nama_project')->first();
    //         $namaPemilik = Project::where('id', $projectPemilikId)->pluck('nama_project')->first();
    //         $material = project_material::where('id', $loanDetail->project_material_id)->first();
    //         $namaMaterial = Material::where('id', $material->material_id)->first();

    //         // Assign nama_project ke $loan
    //         $loan->project_peminjam_name = $namaPeminjam;
    //         $loan->project_pemilik_name = $namaPemilik;
    //         $loan->jumlah = $loanDetail->jumlah;
    //         $loan->nama_material = $namaMaterial->nama;
    //     }

    //     // dd($loans);
        
       
    
    //     return view('loans.index', compact('loans'));
   public function index()
{
    // Ambil semua data loan beserta relasi yang diperlukan sekaligus (eager load)
    $loans = ProjectMaterialLoan::with([
        'details.projectMaterial.material', // relasi ke detail > projectMaterial > material
        'peminjam',                         // relasi ke project peminjam
        'pemilik'                           // relasi ke project pemilik
    ])->latest()->get();

    // Tambahkan nama peminjam, pemilik, dan detail material ke setiap loan
    foreach ($loans as $loan) {
        $loan->project_peminjam_id = optional($loan->peminjam)->nama_project;
        $loan->project_pemilik_id = optional($loan->pemilik)->nama_project;

        // Ambil semua material dari relasi details
        $loan->materials = $loan->details->map(function ($details) {
            return [
                'kode_material' => optional($details->projectMaterial->material)->kode_material,
                'nama_material' => optional($details->projectMaterial->material)->nama,
                'jumlah' => $details->jumlah,
            ];
        });
        
       
    }
    //  dd( $loan->materials = $loan->details);

    return view('loans.index', compact('loans'));
}


    // }

    public function create()
    {
        $projects = Project::all();
        // $projects = project_material::all();
        return view('loans.create', compact('projects'));
    }

    public function getDataLoans()
{
    $details = ProjectMaterialLoanDetail::with([
        'loan.peminjam',
        'loan.pemilik',
        'projectMaterial.material',
    ])->latest();

    return DataTables::eloquent($details)
        ->addColumn('project_peminjam_name', function ($detail) {
            return optional($detail->loan->peminjam)->nama_project ?? '-';
        })
        ->addColumn('project_pemilik_name', function ($detail) {
            return optional($detail->loan->pemilik)->nama_project ?? '-';
        })
        ->addColumn('nama_material', function ($detail) {
            return optional($detail->projectMaterial->material)->nama ?? '-';
        })
          ->addColumn('kode_material', function ($detail) {
            return optional($detail->projectMaterial->material)->kode_material ?? '-';
        })
        ->addColumn('jumlah', function ($detail) {
            return $detail->jumlah;
        })
        ->addColumn('tanggal_pinjam', function ($detail) {
            return $detail->loan->tanggal_pinjam ?? '-';
        })
        ->addColumn('status', function ($detail) {
            return ucfirst($detail->loan->status);
        })
        ->addColumn('action', function ($detail) {
            if ($detail->loan->status === 'dipinjam') {
                return '
                    <form action="'.route('loans.return', $detail->loan->id).'" method="POST">
                        '.csrf_field().'
                        <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                    </form>
                ';
            } else {
                return '<span class="badge badge-secondary">Sudah dikembalikan</span>';
            }
        })
        ->rawColumns(['action'])
        ->make(true);
}


  public function getDataLoansMaterial(Request $request)
{
      $query = project_material::with('material')
            ->where('jumlah', '>', 0);

        // Filter by project_id (project pemilik)
        if ($request->has('project_id') && $request->project_id) {
            $query->where('kode_project', $request->project_id);
        }

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                // Handling global search
                if ($request->has('search') && $request->search['value']) {
                    $searchValue = $request->search['value'];
                    
                    $query->whereHas('material', function($q) use ($searchValue) {
                        $q->where('kode_material', 'like', "%{$searchValue}%")
                          ->orWhere('nama', 'like', "%{$searchValue}%");
                    })
                    ->orWhere('jumlah', 'like', "%{$searchValue}%");
                }
                
                // Handle individual column filtering if implemented in your UI
                if ($request->has('columns')) {
                    foreach ($request->columns as $index => $column) {
                        if (isset($column['search']['value']) && !empty($column['search']['value'])) {
                            $columnName = $column['name'] ?? $column['data'];
                            $searchValue = $column['search']['value'];
                            
                            if ($columnName == 'material.kode_material') {
                                $query->whereHas('material', function($q) use ($searchValue) {
                                    $q->where('kode_material', 'like', "%{$searchValue}%");
                                });
                            }
                            else if ($columnName == 'material.nama_material') {
                                $query->whereHas('material', function($q) use ($searchValue) {
                                    $q->where('nama', 'like', "%{$searchValue}%");
                                });
                            }
                            else if ($columnName == 'jumlah') {
                                $query->where('jumlah', 'like', "%{$searchValue}%");
                            }
                        }
                    }
                }
            })
            ->addColumn('material.kode_material', function ($projectMaterial) {
                return $projectMaterial->material->kode_material ?? '-';
            })
            ->addColumn('material.nama_material', function ($projectMaterial) {
                return $projectMaterial->material->nama ?? '-';
            })
            ->addColumn('jumlah', function ($projectMaterial) {
                return $projectMaterial->jumlah ?? '-';
            })
            ->addColumn('id', function ($projectMaterial) {
                return $projectMaterial->id; // dipakai sebagai key input field
            })
            ->rawColumns(['material.kode_material', 'material.nama_material', 'jumlah'])
            ->make(true);
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
                    'kode_material' => $item->material->kode_material,
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
