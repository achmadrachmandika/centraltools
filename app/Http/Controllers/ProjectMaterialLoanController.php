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
        return view('loans.create', compact('projects'));
    }

    public function getData()
    {
        $query = ProjectMaterialLoan::with(['peminjam', 'pemilik', 'details.projectMaterial.material'])
            ->select('project_material_loans.*');

        return DataTables::of($query)
            ->addColumn('project_peminjam_name', function ($loan) {
                return $loan->peminjam->nama_project;
            })
            ->addColumn('project_pemilik_name', function ($loan) {
                return $loan->pemilik->nama_project;
            })
            ->addColumn('kode_material', function ($loan) {
                $codes = $loan->details->map(function ($detail) {
                    return $detail->projectMaterial->material->kode_material;
                })->unique()->implode(', ');

                return \Str::limit($codes, 50);
            })
            ->addColumn('nama_material', function ($loan) {
                $materials = $loan->details->map(function ($detail) {
                    return $detail->projectMaterial->material->nama;
                })->unique()->implode(', ');

                return \Str::limit($materials, 50);
            })
            ->addColumn('jumlah', function ($loan) {
                return $loan->details->sum('jumlah');
            })
            ->addColumn('action', function ($loan) {
                $buttons = '<div class="btn-group" role="group">';

                // Detail button
                $buttons .= '<a href="' . route('loans.show', $loan->id) . '" class="btn btn-sm btn-info" title="Detail">
                          <i class="fas fa-eye"></i>
                        </a>';

                // Return buttons based on loan status
                if ($loan->status !== 'dikembalikan') {
                    // Partial return button
                    $buttons .= '<a href="' . route('loans.return-form', $loan->id) . '" class="btn btn-sm btn-primary ml-1" title="Pengembalian Parsial">
                              <i class="fas fa-check-square"></i> Kembalikan
                            </a>';

                    // Full return button
                    // $buttons .= '<a href="' . route('loans.return', $loan->id) . '" class="btn btn-sm btn-success ml-1" 
                    //          onclick="return confirm(\'Kembalikan semua material peminjaman ini?\')" title="Kembalikan Semua">
                    //           <i class="fas fa-undo"></i> Kembalikan Semua
                    //         </a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
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
                    <form action="' . route('loans.return', $detail->loan->id) . '" method="POST">
                        ' . csrf_field() . '
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

                    $query->whereHas('material', function ($q) use ($searchValue) {
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
                                $query->whereHas('material', function ($q) use ($searchValue) {
                                    $q->where('kode_material', 'like', "%{$searchValue}%");
                                });
                            } else if ($columnName == 'material.nama_material') {
                                $query->whereHas('material', function ($q) use ($searchValue) {
                                    $q->where('nama', 'like', "%{$searchValue}%");
                                });
                            } else if ($columnName == 'jumlah') {
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
                // Dapatkan data project_material
                $projectMaterial = project_material::find($project_material_id);

                if ($projectMaterial && $projectMaterial->jumlah >= $jumlah_pinjam) {
                    // Simpan detail peminjaman
                    ProjectMaterialLoanDetail::create([
                        'loan_id' => $loan->id,
                        'project_material_id' => $project_material_id,
                        'jumlah' => $jumlah_pinjam,
                    ]);

                    // Update stok project material (kurangi jumlah)
                    $projectMaterial->jumlah -= $jumlah_pinjam;
                    $projectMaterial->save();

                    // Ambil material_id dari project_material
                    $material_id = $projectMaterial->material_id;

                    // Update total stok di tabel materials
                    $totalStok = project_material::where('material_id', $material_id)->sum('jumlah');
                    Material::where('id', $material_id)->update(['jumlah' => $totalStok]);
                } else {
                    // Log warning jika stok tidak cukup
                    \Log::warning("Stok material tidak cukup untuk ProjectMaterial ID: $project_material_id");
                    return redirect()->back()->with('error', 'Stok material tidak cukup untuk beberapa item yang dipilih.');
                }
            }
        }

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil disimpan.');
    }


    public function show($id)
    {
        $loan = ProjectMaterialLoan::with([
            'peminjam',
            'pemilik',
            'details.projectMaterial.material',
            'details' => function ($query) {
                $query->orderBy('status', 'asc'); // Menampilkan yang masih dipinjam terlebih dahulu
            }
        ])->findOrFail($id);

        // Hitung total item yang sudah dikembalikan
        $returnedCount = $loan->details->where('status', 'dikembalikan')->count();
        $totalItems = $loan->details->count();

        return view('loans.show', compact('loan', 'returnedCount', 'totalItems'));
    }


    // public function returnLoan($id)
    // {
    //     $loan = ProjectMaterialLoan::with('details.projectMaterial')->findOrFail($id);

    //     // Pastikan peminjaman masih dalam status dipinjam
    //     if ($loan->status !== 'dipinjam') {
    //         return redirect()->back()->with('error', 'Peminjaman ini sudah dikembalikan sebelumnya.');
    //     }

    //     // Kumpulkan material_id yang akan diupdate total stoknya
    //     $materialIdsToUpdate = [];

    //     // Proses pengembalian untuk setiap detail
    //     foreach ($loan->details as $detail) {
    //         // Ambil project material terkait
    //         $projectMaterial = $detail->projectMaterial;

    //         if ($projectMaterial) {
    //             // Tambahkan jumlah material yang dikembalikan
    //             $projectMaterial->jumlah += $detail->jumlah;
    //             $projectMaterial->save();

    //             // Simpan material_id untuk update total stok nanti
    //             $materialIdsToUpdate[] = $projectMaterial->material_id;
    //         } else {
    //             \Log::warning("Project Material tidak ditemukan untuk detail loan ID: {$detail->id}");
    //         }
    //     }

    //     // Update status peminjaman
    //     $loan->update([
    //         'status' => 'dikembalikan',
    //         'tanggal_dikembalikan' => now(),
    //     ]);

    //     // Update total stok untuk semua material yang terlibat
    //     $materialIdsToUpdate = array_unique($materialIdsToUpdate);
    //     foreach ($materialIdsToUpdate as $materialId) {
    //         $totalStok = project_material::where('material_id', $materialId)->sum('jumlah');
    //         Material::where('id', $materialId)->update(['jumlah' => $totalStok]);
    //     }

    //     return redirect()->back()->with('success', 'Material berhasil dikembalikan.');
    // }

    public function returnLoan($id)
    {
        // Gunakan DB transaction untuk memastikan konsistensi data
        DB::beginTransaction();

        try {
            $loan = ProjectMaterialLoan::with('details.projectMaterial')->lockForUpdate()->findOrFail($id);

            // Cek status peminjaman
            if ($loan->status !== 'dipinjam' && $loan->status !== 'dikembalikan sebagian') {
                DB::rollBack();
                return redirect()->back()->with('error', 'Peminjaman ini sudah dikembalikan sebelumnya.');
            }

            // Kumpulkan material_id yang akan diupdate total stoknya
            $materialIdsToUpdate = [];
            $detailsUpdated = false;

            // Proses pengembalian untuk setiap detail
            foreach ($loan->details as $detail) {
                // Hanya proses jika status detail bukan dikembalikan
                if ($detail->status !== 'dikembalikan') {
                    // Ambil project material terkait
                    $projectMaterial = $detail->projectMaterial;

                    if ($projectMaterial) {
                        // Tambahkan jumlah material yang dikembalikan
                        $projectMaterial->jumlah += $detail->jumlah;
                        $projectMaterial->save();

                        // Update status detail menjadi dikembalikan
                        $detail->status = 'dikembalikan';
                        $detail->save();

                        // Simpan material_id untuk update total stok nanti
                        $materialIdsToUpdate[] = $projectMaterial->material_id;
                        $detailsUpdated = true;
                    } else {
                        \Log::warning("Project Material tidak ditemukan untuk detail loan ID: {$detail->id}");
                    }
                }
            }

            // Jika tidak ada detail yang diupdate, batalkan transaksi
            if (!$detailsUpdated) {
                DB::rollBack();
                return redirect()->back()->with('info', 'Tidak ada perubahan yang dilakukan.');
            }

            // Update status peminjaman
            $loan->update([
                'status' => 'dikembalikan',
                'tanggal_dikembalikan' => now(),
            ]);

            // Update total stok untuk semua material yang terlibat
            $materialIdsToUpdate = array_unique($materialIdsToUpdate);
            foreach ($materialIdsToUpdate as $materialId) {
                $totalStok = ProjectMaterial::where('material_id', $materialId)->sum('jumlah');
                Material::where('id', $materialId)->update(['jumlah' => $totalStok]);
            }

            // Commit transaksi
            DB::commit();
            return redirect()->back()->with('success', 'Material berhasil dikembalikan.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            \Log::error("Error saat mengembalikan peminjaman: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pengembalian.');
        }
    }

    public function showReturnForm($id)
    {
        $loan = ProjectMaterialLoan::with('details.projectMaterial.material')->findOrFail($id);

        // Cek apakah masih ada item yang belum dikembalikan
        if ($loan->status === 'dikembalikan' || $loan->details->where('status', '!=', 'dikembalikan')->count() === 0) {
            return redirect()->route('loans.index')->with('error', 'Semua item sudah dikembalikan.');
        }

        return view('loans.detail', compact('loan'));
    }
    public function processReturn(Request $request, $id)
    {
        $loan = ProjectMaterialLoan::with('details.projectMaterial.material')->findOrFail($id);

        // Validasi input
        $request->validate([
            'detail_ids' => 'required|array',
            'detail_ids.*' => 'exists:project_material_loan_details,id'
        ]);

        $materialIdsToUpdate = [];

        // For debugging
        \Log::info('Processing return for loan ID: ' . $id);
        \Log::info('Selected detail IDs: ', $request->detail_ids);

        // Proses pengembalian untuk setiap detail yang dipilih
        foreach ($request->detail_ids as $detailId) {
            // Use find instead of firstWhere on the collection
            $detail = $loan->details->where('id', $detailId)->first();

            \Log::info('Processing detail ID: ' . $detailId . ', Status: ' . ($detail ? $detail->status : 'Not found'));

            if ($detail && $detail->status !== 'dikembalikan') {
                // Ambil project material terkait
                $projectMaterial = $detail->projectMaterial;

                if ($projectMaterial) {
                    \Log::info('Found project material ID: ' . $projectMaterial->id);

                    // Tambahkan jumlah material yang dikembalikan
                    $projectMaterial->jumlah += $detail->jumlah;
                    $projectMaterial->save();

                    // Update status detail menjadi dikembalikan
                    $detail->status = 'dikembalikan';
                    $detail->save();

                    // Simpan material_id untuk update total stok nanti
                    $materialIdsToUpdate[] = $projectMaterial->material_id;

                    \Log::info('Updated project material and detail status');
                } else {
                    \Log::warning('Project Material not found for detail ID: ' . $detailId);
                }
            } else {
                \Log::warning('Detail not found or already returned for ID: ' . $detailId);
            }
        }

        // Cek apakah semua item sudah dikembalikan
        $pendingDetails = $loan->details->where('status', '!=', 'dikembalikan')->count();
        \Log::info('Pending details count: ' . $pendingDetails);

        if ($pendingDetails === 0) {
            $loan->status = 'dikembalikan';
            $loan->tanggal_dikembalikan = now();
            $loan->save();
            \Log::info('Updated loan status to returned');
        }

        // Update total stok untuk semua material yang terlibat
        $materialIdsToUpdate = array_unique($materialIdsToUpdate);
        foreach ($materialIdsToUpdate as $materialId) {
            $totalStok = project_material::where('material_id', $materialId)->sum('jumlah');
            Material::where('id', $materialId)->update(['jumlah' => $totalStok]);
            \Log::info('Updated total stock for material ID: ' . $materialId . ' to ' . $totalStok);
        }

        return redirect()->route('loans.index')->with('success', 'Material berhasil dikembalikan.');
    }


}
