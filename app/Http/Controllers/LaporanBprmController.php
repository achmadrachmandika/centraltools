<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;
use App\Models\Bprm;
use App\Models\BprmMaterial;
use App\Models\Material;
use App\Models\Bagian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
class LaporanBprmController extends Controller
{

public function laporanTanggal(Request $request)
{
    $projectId = $request->input('project_id');
    $startDateInput = $request->input('start_date');
    $endDateInput = $request->input('end_date');

    // Tentukan rentang tanggal
    $earliestDate = $startDateInput ?: Bprm::min('tgl_bprm');
    $latestDate = $endDateInput ?: Bprm::max('tgl_bprm');

    $startDate = Carbon::parse($earliestDate ?: now()->startOfMonth());
    $endDate = Carbon::parse($latestDate ?: now()->endOfMonth());

    // Ambil semua project untuk dropdown/filter
    $projectArray = Project::all();

    // Query BPRM berdasarkan tanggal dan project
    $bprmsQuery = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate]);

    if ($projectId) {
        $bprmsQuery->where('project_id', $projectId);
    }

    $bprms = $bprmsQuery->with(['bprmMaterials.material', 'project'])->get();

    // Hari dalam bahasa Inggris ke Indonesia
    $hari = [
        'Monday' => 'senin',
        'Tuesday' => 'selasa',
        'Wednesday' => 'rabu',
        'Thursday' => 'kamis',
        'Friday' => 'jumat',
        'Saturday' => 'sabtu',
        'Sunday' => 'minggu'
    ];

    // Siapkan struktur laporan berdasarkan hari
    $laporanTanggal = [];

    foreach ($bprms as $bprm) {
        foreach ($bprm->bprmMaterials as $bprmMaterial) {
            $kodeMaterial = $bprmMaterial->material->kode_material ?? '-';
            $namaMaterial = $bprmMaterial->material->nama ?? '-';
            $spek = $bprmMaterial->material->spek ?? '-';
            $jumlah = $bprmMaterial->jumlah_material;

            $tanggal = Carbon::parse($bprm->tgl_bprm);
            $dayName = strtolower($hari[$tanggal->format('l')]); // senin, selasa, dst

            if (!isset($laporanTanggal[$kodeMaterial])) {
                $laporanTanggal[$kodeMaterial] = [
                    'kode_material' => $kodeMaterial,
                    'nama_material' => $namaMaterial,
                    'spek' => $spek,
                    'days' => [
                        'senin' => 0,
                        'selasa' => 0,
                        'rabu' => 0,
                        'kamis' => 0,
                        'jumat' => 0,
                        'sabtu' => 0,
                        'minggu' => 0,
                    ],
                    'total' => 0
                ];
            }

            $laporanTanggal[$kodeMaterial]['days'][$dayName] += $jumlah;
            $laporanTanggal[$kodeMaterial]['total'] += $jumlah;
        }
    }

    // Ubah ke array numerik untuk looping di Blade
    $laporanTanggal = array_values($laporanTanggal);

    // Buat array tanggal dan hari pertama
    $dates = [];
    $firstWeekDates = [
        'Senin' => null,
        'Selasa' => null,
        'Rabu' => null,
        'Kamis' => null,
        'Jumat' => null,
        'Sabtu' => null,
        'Minggu' => null,
    ];

    $dayMapping = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
        'Sunday' => 'Minggu'
    ];

    $currentDate = $startDate->copy();
    while ($currentDate->lte($endDate)) {
        $dayName = $dayMapping[$currentDate->format('l')];
        $formattedDate = $currentDate->format('d-m-Y');

        $dates[] = [
            'day' => $dayName,
            'date' => $formattedDate
        ];

        if (!$firstWeekDates[$dayName]) {
            $firstWeekDates[$dayName] = $formattedDate;
        }

        $currentDate->addDay();
    }

    $filterdigunakan = $request->has('filter');

    return view('laporan.tanggal', compact(
        'laporanTanggal',
        'startDate',
        'endDate',
        'projectArray',
        'dates',
        'firstWeekDates',
        'filterdigunakan',
        'projectId',
        'startDateInput',
        'endDateInput'
    ));
}




 public function filterLaporanTanggal(Request $request)
{
    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
    $today = Carbon::today()->endOfDay();

    // Validasi tanggal
    if ($startDate->isAfter($today)) {
        return Redirect::back()->with('error', 'Tanggal awal tidak boleh lebih dari hari ini');
    }

    if ($startDate->format('l') !== 'Monday') {
        return Redirect::back()->with('error', 'Hari awal bukan Senin');
    }

    if ($endDate->format('l') !== 'Sunday') {
        return Redirect::back()->with('error', 'Hari akhir bukan Minggu');
    }

    if ($startDate->diffInDays($endDate) !== 6) {
        return Redirect::back()->with('error', 'Range hari harus 1 minggu');
    }

    $projectArray = Project::all();

    // Ambil data BPRM + relasi
    $bprms = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate])
        ->with(['bprmMaterials.material', 'project'])
        ->get();

    // Map hari Inggris ke Indonesia
    $hari = [
        'Monday' => 'senin',
        'Tuesday' => 'selasa',
        'Wednesday' => 'rabu',
        'Thursday' => 'kamis',
        'Friday' => 'jumat',
        'Saturday' => 'sabtu',
        'Sunday' => 'minggu'
    ];

    // Rekap per material dan hari
    $laporanTanggal = [];

    foreach ($bprms as $bprm) {
        foreach ($bprm->bprmMaterials as $bprmMaterial) {
            $kodeMaterial = $bprmMaterial->material->kode_material ?? '-';
            $namaMaterial = $bprmMaterial->material->nama ?? '-';
            $spek = $bprmMaterial->material->spek ?? '-';
            $jumlah = $bprmMaterial->jumlah_material;

            $tanggal = Carbon::parse($bprm->tgl_bprm);
            $dayName = strtolower($hari[$tanggal->format('l')]);

            if (!isset($laporanTanggal[$kodeMaterial])) {
                $laporanTanggal[$kodeMaterial] = [
                    'kode_material' => $kodeMaterial,
                    'nama_material' => $namaMaterial,
                    'spek' => $spek,
                    'days' => [
                        'senin' => 0,
                        'selasa' => 0,
                        'rabu' => 0,
                        'kamis' => 0,
                        'jumat' => 0,
                        'sabtu' => 0,
                        'minggu' => 0,
                    ],
                    'total' => 0
                ];
            }

            $laporanTanggal[$kodeMaterial]['days'][$dayName] += $jumlah;
            $laporanTanggal[$kodeMaterial]['total'] += $jumlah;
        }
    }

    $laporanTanggal = array_values($laporanTanggal); // konversi ke array numerik

    // Buat data tanggal & nama hari
    $dates = [];
    $firstWeekDates = [
        'Senin' => null,
        'Selasa' => null,
        'Rabu' => null,
        'Kamis' => null,
        'Jumat' => null,
        'Sabtu' => null,
        'Minggu' => null,
    ];

    $dayMapping = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
        'Sunday' => 'Minggu'
    ];

    $currentDate = $startDate->copy();
    while ($currentDate->lte($endDate)) {
        $dayName = $dayMapping[$currentDate->format('l')];
        $formattedDate = $currentDate->format('d-m-Y');

        $dates[] = [
            'day' => $dayName,
            'date' => $formattedDate
        ];

        if (!$firstWeekDates[$dayName]) {
            $firstWeekDates[$dayName] = $formattedDate;
        }

        $currentDate->addDay();
    }

    $filterdigunakan = true;

    return view('laporan.tanggal', compact(
        'laporanTanggal',
        'startDate',
        'endDate',
        'projectArray',
        'dates',
        'firstWeekDates',
        'filterdigunakan'
    ));
}


public function calculateTotals($bprms)
{
    $totals = [];

    foreach ($bprms as $bprm) {
        // Looping untuk jumlah material 1 sampai 10
        for ($i = 1; $i <= 10; $i++) {
            $kodeMaterial = 'kode_material_' . $i;
            $jumlahMaterial = 'jumlah_material_' . $i;
            $namaMaterial = 'nama_material_' . $i;
            $spekMaterial = 'spek_material_' . $i;

            // Cek apakah data kode material dan jumlah material ada
            if (!empty($bprm->$kodeMaterial) && !empty($bprm->$jumlahMaterial)) {
                // Jika kode material belum ada di totals, buat entry baru
                if (!isset($totals[$bprm->$kodeMaterial])) {
                    $totals[$bprm->$kodeMaterial] = [
                        'nama_material' => $bprm->$namaMaterial,
                        'total' => 0,
                        'projects' => [],
                        'spek' => $bprm->$spekMaterial,
                        'bagian' => [],
                        'days' => [
                            'senin' => 0,
                            'selasa' => 0,
                            'rabu' => 0,
                            'kamis' => 0,
                            'jumat' => 0,
                            'sabtu' => 0,
                            'minggu' => 0,
                        ]
                    ];
                }

                // Dapatkan hari dalam minggu berdasarkan tanggal BPRM
                $dayOfWeek = Carbon::parse($bprm->tgl_bprm)->format('l'); // Format untuk hari (Senin - Minggu)

                // Update jumlah berdasarkan hari dalam minggu
                switch (strtolower($dayOfWeek)) {
                    case 'monday':
                        $totals[$bprm->$kodeMaterial]['days']['senin'] += intval($bprm->$jumlahMaterial);
                        break;
                    case 'tuesday':
                        $totals[$bprm->$kodeMaterial]['days']['selasa'] += intval($bprm->$jumlahMaterial);
                        break;
                    case 'wednesday':
                        $totals[$bprm->$kodeMaterial]['days']['rabu'] += intval($bprm->$jumlahMaterial);
                        break;
                    case 'thursday':
                        $totals[$bprm->$kodeMaterial]['days']['kamis'] += intval($bprm->$jumlahMaterial);
                        break;
                    case 'friday':
                        $totals[$bprm->$kodeMaterial]['days']['jumat'] += intval($bprm->$jumlahMaterial);
                        break;
                    case 'saturday':
                        $totals[$bprm->$kodeMaterial]['days']['sabtu'] += intval($bprm->$jumlahMaterial);
                        break;
                    case 'sunday':
                        $totals[$bprm->$kodeMaterial]['days']['minggu'] += intval($bprm->$jumlahMaterial);
                        break;
                }

                // Tambahkan data proyek terkait material
                $totals[$bprm->$kodeMaterial]['projects'][] = [
                    'project' => $bprm->project ? $bprm->project->nama_project : 'Unknown Project', // Nama proyek
                    'jumlah' => intval($bprm->$jumlahMaterial),
                    'nama_admin' => $bprm->nama_admin,
                    'spek' => $bprm->$spekMaterial, // Pastikan menyertakan spek
                    'bagian' => $bprm->bagian,
                    'tgl_bprm' => $bprm->tgl_bprm, // Tanggal BPRM
                ];

                // Update total jumlah material
                $totals[$bprm->$kodeMaterial]['total'] += intval($bprm->$jumlahMaterial);

                // Pastikan bagian tidak duplikat
                if (!in_array($bprm->bagian, $totals[$bprm->$kodeMaterial]['bagian'])) {
                    $totals[$bprm->$kodeMaterial]['bagian'][] = $bprm->bagian;
                }
            }
        }
    }

    return $totals;
}

    // public function calculateTotals($bprms)
    // {
    //     $totals = [];

    // foreach ($bprms as $bprm) {
    //     for ($i = 1; $i <= 10; $i++) {
    //         $kodeMaterial = 'kode_material_' . $i;
    //         $jumlahMaterial = 'jumlah_material_' . $i;
    //         $namaMaterial = 'nama_material_' . $i;
    //         $spekMaterial = 'spek_material_' . $i;
            

    //         if (!empty($bprm->$kodeMaterial) && !empty($bprm->$jumlahMaterial)) {
    //             if (!isset($totals[$bprm->$kodeMaterial])) {
    //                 $totals[$bprm->$kodeMaterial] = [
    //                     'nama_material' => $bprm->$namaMaterial,
    //                     'total' => 0,
    //                     'projects' => [],
    //                     'spek' => $bprm->$spekMaterial,
    //                     'bagian' => [],
    //                     'days' => [
    //                         'senin' => 0,
    //                         'selasa' => 0,
    //                         'rabu' => 0,
    //                         'kamis' => 0,
    //                         'jumat' => 0,
    //                         'sabtu' => 0,
    //                         'minggu' => 0,
    //                     ]
    //                 ];
    //             }

    //             $dayOfWeek = Carbon::parse($bprm->tgl_bprm)->format('l');

    //             switch (strtolower($dayOfWeek)) {
    //                 case 'monday':
    //                     $totals[$bprm->$kodeMaterial]['days']['senin'] += intval($bprm->$jumlahMaterial);
    //                     break;
    //                 case 'tuesday':
    //                     $totals[$bprm->$kodeMaterial]['days']['selasa'] += intval($bprm->$jumlahMaterial);
    //                     break;
    //                 case 'wednesday':
    //                     $totals[$bprm->$kodeMaterial]['days']['rabu'] += intval($bprm->$jumlahMaterial);
    //                     break;
    //                 case 'thursday':
    //                     $totals[$bprm->$kodeMaterial]['days']['kamis'] += intval($bprm->$jumlahMaterial);
    //                     break;
    //                 case 'friday':
    //                     $totals[$bprm->$kodeMaterial]['days']['jumat'] += intval($bprm->$jumlahMaterial);
    //                     break;
    //                 case 'saturday':
    //                     $totals[$bprm->$kodeMaterial]['days']['sabtu'] += intval($bprm->$jumlahMaterial);
    //                     break;
    //                 case 'sunday':
    //                     $totals[$bprm->$kodeMaterial]['days']['minggu'] += intval($bprm->$jumlahMaterial);
    //                     break;
    //             }

    //             $totals[$bprm->$kodeMaterial]['projects'][] = [
    //                 'project' => $bprm->project,
    //                 'jumlah' => intval($bprm->$jumlahMaterial),
    //                 'nama_admin' => $bprm->nama_admin,
    //                 'spek' => $bprm->spek,
    //                 'bagian' => $bprm->bagian,
    //                 'tgl_bprm' => $bprm->tgl_bprm, // Tambahkan tanggal di sini
    //             ];

    //             $totals[$bprm->$kodeMaterial]['total'] += intval($bprm->$jumlahMaterial);
    //         }
    //     }
    // }

    // return $totals;
    // }

     public function laporanProject(Request $request)
{
    // Ambil parameter proyek dan tanggal dari request
    $projectId = $request->input('project_id');
    $startDateInput = $request->input('start_date');
    $endDateInput = $request->input('end_date');

    // Ambil tanggal awal dan akhir dari tabel Bprm jika tidak ada input tanggal
    $earliestDate = $startDateInput ? Carbon::parse($startDateInput) : Bprm::min('tgl_bprm');
    $latestDate = $endDateInput ? Carbon::parse($endDateInput) : Bprm::max('tgl_bprm');

    // Parse tanggal
    $startDate = $earliestDate ? Carbon::parse($earliestDate) : now()->startOfMonth();
    $endDate = $latestDate ? Carbon::parse($latestDate) : now()->endOfMonth();

    $projectArray = Project::all();

    // Ambil data BPRM dengan relasi material dan project
    $bprmsQuery = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate]);


    if ($projectId) {
        $bprmsQuery->where('project_id', $projectId);
    }

    $bprms = $bprmsQuery->with(['bprmMaterials.material', 'project'])->get();

    $totals = $this->calculateTotals($bprms);
 

    // Ambil data laporan per material berdasarkan proyek
    $laporanProject = $bprms->flatMap(function ($bprm) {
        return $bprm->bprmMaterials->map(function ($bprmMaterial) use ($bprm) {
            return [
                'kode_material' => $bprmMaterial->material->kode_material ?? '-',
                'nama_material' => $bprmMaterial->material->nama ?? '-',
                'spek' => $bprmMaterial->material->spek ?? '-',
                'total' => $bprmMaterial->jumlah_material,
                'project' => $bprm->project,
                'tanggal' => $bprm->tgl_bprm,
                'bagian' => $bprm->bagian,
            ];
        });
    });
    // dd($laporanProject);

    return view('laporan.project', compact(
        'laporanProject',
        'totals',
        'startDate',
        'endDate',
        'projectArray',
        'projectId',
        'startDateInput',
        'endDateInput'
    ));
}

public function filterLaporanProject(Request $request)
{
    // Ambil parameter tanggal dan project dari request
    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
    $projectId = $request->input('project');

    // Ambil semua data proyek untuk dropdown
    $projectArray = Project::all();

    // Query untuk mengambil data BPRM
    $bprmsQuery = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate]);

    // Menyaring berdasarkan project jika ada
    if ($projectId) {
        $bprmsQuery->where('project', $projectId); // Menggunakan kolom 'project' bukan 'project_id'
    }

    // Mengambil data BPRM beserta relasi bprmMaterials dan project
    $bprms = $bprmsQuery->with(['bprmMaterials.material', 'project'])->get();

    // Menghitung total menggunakan fungsi yang sudah ada
    $totals = $this->calculateTotals($bprms);

    // Membuat laporan per material berdasarkan proyek
    $laporanProject = $bprms->flatMap(function ($bprm) {
        return $bprm->bprmMaterials->map(function ($bprmMaterial) use ($bprm) {
            return [
                'kode_material' => $bprmMaterial->material->kode_material ?? '-',
                'nama_material' => $bprmMaterial->material->nama ?? '-',
                'spek' => $bprmMaterial->material->spek ?? '-',
                'total' => $bprmMaterial->jumlah_material,
                'project' => $bprm->project ?? '-',
                'tanggal' => $bprm->tgl_bprm,
                'bagian' => $bprm->bagian,
            ];
        });
    });

    // Menambahkan startDateInput dan endDateInput untuk dikirim ke tampilan
    $startDateInput = $startDate->toDateString();
    $endDateInput = $endDate->toDateString();

    // Kembalikan tampilan dengan data yang sudah diproses
    return view('laporan.project', compact(
        'laporanProject', // Mengirimkan data laporan untuk ditampilkan
        'totals',         // Mengirimkan data total untuk ditampilkan
        'startDate',      // Tanggal mulai
        'endDate',        // Tanggal akhir
        'projectArray',   // Data proyek untuk dropdown
        'projectId',      // ID proyek yang dipilih
        'startDateInput', // Tanggal mulai input
        'endDateInput'    // Tanggal akhir input
    ));
}




public function laporanBagian(Request $request)
{
    $projectId = $request->input('project_id');
    $startDateInput = $request->input('start_date');
    $endDateInput = $request->input('end_date');
    $bagianList = Bagian::pluck('nama_bagian')->toArray();

    $earliestDate = $startDateInput ? Carbon::parse($startDateInput) : Bprm::min('tgl_bprm');
    $latestDate = $endDateInput ? Carbon::parse($endDateInput) : Bprm::max('tgl_bprm');

    $startDate = $earliestDate ? Carbon::parse($earliestDate) : now()->startOfMonth();
    $endDate = $latestDate ? Carbon::parse($latestDate) : now()->endOfMonth();

    $projectArray = project::all();

    $bprmsQuery = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate]);
   

    // if ($projectId) {
    //     $bprmsQuery->where('project', $projectId);
    // }
    if ($projectId) {
    $bprmsQuery->where('project_id', $projectId); 
}

     

    $bprms = $bprmsQuery->with(['bprmMaterials.material', 'project'])->get();
     

    $totals = $this->calculateTotals($bprms);


   

    // Ambil data laporan bagian
    $laporanBagian = $bprms->flatMap(function ($bprm) {

     
    return $bprm->bprmMaterials->map(function ($bprmMaterial) use ($bprm) {
        
        return [
            'kode_material' => $bprmMaterial->material->kode_material ?? '-',
            'nama_material' => $bprmMaterial->material->nama ?? '-',
            'spek' => $bprmMaterial->material->spek ?? '-',
            'total' => $bprmMaterial->jumlah_material,
            'project' => $bprm->project,
            'tanggal' => $bprm->tgl_bprm,
            'bagian' => $bprm->bagian
        ];

     

  
    });
     
    
});
//  dd($laporanBagian);


    return view('laporan.bagian', compact('laporanBagian', 'bagianList', 'totals', 'startDate', 'endDate', 'projectArray', 'projectId', 'startDateInput', 'endDateInput'));
}


public function filterLaporanBagian(Request $request)
{
    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
    $projectId = $request->input('project');
    $filterBagian = $request->input('bagian'); // nama bagian, contoh: 'Divisi Produksi'

    // Ambil semua data bagian untuk dropdown filter
    $bagianList = Bagian::pluck('nama_bagian')->toArray();

    $bprmsQuery = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate]);

    if (!empty($filterBagian)) {
        $bprmsQuery->where('bagian', $filterBagian); // cocokkan string nama bagian
    }

    if (!empty($projectId)) {
        $bprmsQuery->where('project', $projectId);
    }

    $bprms = $bprmsQuery->with(['bprmMaterials.material'])->get();
    $totals = $this->calculateTotals($bprms);

      $laporanBagian = $bprms->flatMap(function ($bprm) {
    return $bprm->bprmMaterials->map(function ($bprmMaterial) use ($bprm) {
        return [
            'kode_material' => $bprmMaterial->material->kode_material ?? '-',
            'nama_material' => $bprmMaterial->material->nama ?? '-',
            'spek' => $bprmMaterial->material->spek ?? '-',
            'total' => $bprmMaterial->jumlah_material,
            'project' => $bprm->project,
            'tanggal' => $bprm->tgl_bprm,
            'bagian' => $bprm->bagian
        ];
        
    });
});


    $projectArray = project::pluck('nama_project', 'id');

    return view('laporan.bagian', compact(
        'laporanBagian',
        'totals',
        'startDate',
        'endDate',
        'projectArray',
        'projectId',
        'filterBagian',
        'bagianList'
    ));
}



public function calculateTotalsMaterial($bprms)
{
    $totals = [];

    foreach ($bprms as $bprm) {
        for ($i = 1; $i <= 10; $i++) {
            $kodeMaterialKey = 'kode_material_' . $i;
            $jumlahMaterialKey = 'jumlah_material_' . $i;
            $namaMaterialKey = 'nama_material_' . $i;
            $spekMaterialKey = 'spek_material_' . $i;

            // Pastikan properti ada dan tidak null
            if (!empty($bprm->$kodeMaterialKey) && !empty($bprm->$jumlahMaterialKey)) {
                $kodeMaterial = $bprm->$kodeMaterialKey;
                $jumlahMaterial = intval($bprm->$jumlahMaterialKey);
                $namaMaterial = $bprm->$namaMaterialKey ?? 'Unknown';
                $spekMaterial = $bprm->$spekMaterialKey ?? 'Unknown';
                $tglBprm = Carbon::parse($bprm->tgl_bprm)->format('d-m-Y');
                $bagian = $bprm->bagian ?? 'Unknown';

                // Inisialisasi jika kode material belum ada dalam array
                if (!isset($totals[$kodeMaterial])) {
                    $totals[$kodeMaterial] = [
                        'nama_material' => $namaMaterial,
                        'spek' => $spekMaterial,
                        'total' => 0,
                        'projects' => [],
                        'bagian' => [],
                        'dates' => []
                    ];
                }

                // Tambahkan jumlah berdasarkan tanggal
                if (!isset($totals[$kodeMaterial]['dates'][$tglBprm])) {
                    $totals[$kodeMaterial]['dates'][$tglBprm] = 0;
                }
                $totals[$kodeMaterial]['dates'][$tglBprm] += $jumlahMaterial;

                // Tambahkan data proyek
                $totals[$kodeMaterial]['projects'][] = [
                    'project' => $bprm->project ?? 'Unknown',
                    'jumlah' => $jumlahMaterial,
                    'nama_admin' => $bprm->nama_admin ?? 'Unknown',
                    'spek' => $spekMaterial,
                    'bagian' => $bagian
                ];

                // Tambahkan ke bagian
                if (!in_array($bagian, $totals[$kodeMaterial]['bagian'])) {
                    $totals[$kodeMaterial]['bagian'][] = $bagian;
                }

                // Perbarui total jumlah material
                $totals[$kodeMaterial]['total'] += $jumlahMaterial;
            }
        }
    }

    return $totals;
}



public function laporanMaterial(Request $request)
{
    // Fetch the earliest and latest dates from the Bprm table
    $earliestDate = Bprm::min('tgl_bprm');
    $latestDate = Bprm::max('tgl_bprm');

    // Parse the dates
     $startDate = Carbon::now()->subWeek(); // 7 days ago
        $endDate = Carbon::now(); // Today

    $projectArray = Project::all();

    // Fetch all Bprm records within the date range
    $bprms = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate])->get();

    // Calculate totals
    $totals = $this->calculateTotalsMaterial($bprms);

    // Initialize an empty array for dates
    $dates = [];

    // Get all dates between the start and end date
    $currentDate = $startDate ? $startDate->copy() : null;

    while ($currentDate && $currentDate->lte($endDate)) {
        $dates[] = [
            'date' => $currentDate->format('d-m-Y')
        ];
        $currentDate->addDay();
    }

    // Check if a filter is applied
    $filterdigunakan = $request->has('filter');

    return view('laporan.material', compact('totals', 'startDate', 'endDate', 'projectArray', 'dates', 'filterdigunakan'));
}


public function filterLaporanMaterial(Request $request)
{
    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

    $projectArray = Project::all();

    // Fetch all Bprm records within the date range
    $bprms = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate])->get();

    // Calculate totals
    $totals = $this->calculateTotalsMaterial($bprms);

    // Initialize an empty array for dates
    $dates = [];

    // Get all dates between the start and end date
    $currentDate = $startDate->copy();

    while ($currentDate->lte($endDate)) {
        $dates[] = [
            'date' => $currentDate->format('d-m-Y')
        ];
        $currentDate->addDay();
    }

    // Indicate that a filter is applied
    $filterdigunakan = true;

    return view('laporan.material', compact('totals', 'startDate', 'endDate', 'projectArray', 'dates', 'filterdigunakan'));
}



// public function filterLaporanMaterial(Request $request)
// {
//     $startDate = Carbon::parse($request->input('start_date'));
//     $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

//     $projectArray = Project::all();

//     // Fetch all Bprm records within the date range
//     $bprms = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate])->get();

//     // Calculate totals
//     $totals = $this->calculateTotalsMaterial($bprms);

//     // Initialize an empty array for dates
//     $dates = [];

//     // Get all dates between the start and end date
//     $currentDate = $startDate->copy();

//     while ($currentDate->lte($endDate)) {
//         $dates[] = [
//             'date' => $currentDate->format('d-m-Y')
//         ];
//         $currentDate->addDay();
//     }

//     // Indicate that a filter is applied
//     $filterdigunakan = true;

//     return view('laporan.material', compact('totals', 'startDate', 'endDate', 'projectArray', 'dates', 'filterdigunakan'));
// }




}