<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;
use App\Models\Bprm;
use App\Models\BprmMaterial;
use App\Models\Material;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
class LaporanBprmController extends Controller
{

public function laporanTanggal(Request $request){
    // Fetch the earliest and latest dates from the Bprm table
    $earliestDate = Bprm::min('tgl_bprm');
    $latestDate = Bprm::max('tgl_bprm');

    

    // Parse the dates
    $startDate = $earliestDate ? Carbon::parse($earliestDate) : null;
    $endDate = $latestDate ? Carbon::parse($latestDate) : null;

    $projectArray = Project::all();

    // Fetch all Bprm records within the date range
    $bprms = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate])->get();
    $totals = $this->calculateTotals($bprms);

    // Get all dates between the start and end date
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

    if ($startDate && $endDate) {
        $currentDate = $startDate->copy();
        $hari = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        while ($currentDate->lte($endDate)) {
            $dayName = $hari[$currentDate->format('l')];
            $dates[] = [
                'day' => $dayName,
                'date' => $currentDate->format('d-m-Y')
            ];

            if (!$firstWeekDates[$dayName]) {
                $firstWeekDates[$dayName] = $currentDate->format('d-m-Y');
            }

            $currentDate->addDay();
        }
    }
    // Check if a filter is applied
    $filterdigunakan = $request->has('filter');

    return view('laporan.tanggal', compact('totals', 'startDate', 'endDate', 'projectArray', 'dates', 'firstWeekDates', 'filterdigunakan'));
}

 public function filterLaporanTanggal(Request $request)
{
    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
    $today = Carbon::today()->endOfDay();

    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
    $today = Carbon::today()->endOfDay();

    if ($startDate->isAfter($today)) {
        return Redirect::back()->with('error', 'Tanggal awal tidak boleh lebih dari hari ini');
    }

    $startDayName = $startDate->format('l'); // Mengambil nama hari dalam bahasa Inggris
    $endDayName = $endDate->format('l'); // Mengambil nama hari dalam bahasa Inggris

    if ($startDayName !== 'Monday') {
        return Redirect::back()->with('error', 'Hari awal bukan Senin');
    } else {
        if ($endDayName !== 'Sunday') {
            return Redirect::back()->with('error', 'Hari akhir bukan Minggu');
        } else {
            // Mencari selisih hari antara $startDate dan $endDate
            $differenceInDays = $startDate->diffInDays($endDate);

            if ($differenceInDays !== 6) {
                return Redirect::back()->with('error', 'Range hari harus 1 minggu');
            } 
        } 
    }

    $projectArray = Project::all();

    $bprms = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate])->get();
    $totals = $this->calculateTotals($bprms);

    // Get all dates between the start and end date
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

    $currentDate = $startDate->copy();
    $hari = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
        'Sunday' => 'Minggu'
    ];

    while ($currentDate->lte($endDate)) {
        $dayName = $hari[$currentDate->format('l')];
        $dates[] = [
            'day' => $dayName,
            'date' => $currentDate->format('d-m-Y')
        ];

        if (!$firstWeekDates[$dayName]) {
            $firstWeekDates[$dayName] = $currentDate->format('d-m-Y');
        }

        $currentDate->addDay();
    }

    // Indicate that a filter is applied
    $filterdigunakan = true;

    return view('laporan.tanggal', compact('totals', 'startDate', 'endDate', 'projectArray', 'dates', 'firstWeekDates', 'filterdigunakan'));
}
    public function calculateTotals($bprms)
    {
        $totals = [];

    foreach ($bprms as $bprm) {
        for ($i = 1; $i <= 10; $i++) {
            $kodeMaterial = 'kode_material_' . $i;
            $jumlahMaterial = 'jumlah_material_' . $i;
            $namaMaterial = 'nama_material_' . $i;
            $spekMaterial = 'spek_material_' . $i;
            

            if (!empty($bprm->$kodeMaterial) && !empty($bprm->$jumlahMaterial)) {
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

                $dayOfWeek = Carbon::parse($bprm->tgl_bprm)->format('l');

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

                $totals[$bprm->$kodeMaterial]['projects'][] = [
                    'project' => $bprm->project,
                    'jumlah' => intval($bprm->$jumlahMaterial),
                    'nama_admin' => $bprm->nama_admin,
                    'spek' => $bprm->spek,
                    'bagian' => $bprm->bagian,
                    'tgl_bprm' => $bprm->tgl_bprm, // Tambahkan tanggal di sini
                ];

                $totals[$bprm->$kodeMaterial]['total'] += intval($bprm->$jumlahMaterial);
            }
        }
    }

    return $totals;
    }

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
    $startDate = $earliestDate ? Carbon::parse($earliestDate) : null;
    $endDate = $latestDate ? Carbon::parse($latestDate) : null;

    $projectArray = Project::all();

    // Fetch all Bprm records within the date range and filter by project if provided
    $bprmsQuery = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate]);

    if ($projectId) {
        $bprmsQuery->where('project_id', $projectId); // Asumsikan kolom 'project_id' ada di tabel Bprm
    }

    $bprms = $bprmsQuery->get();
    $totals = $this->calculateTotals($bprms);

    // Get all dates between the start and end date


    return view('laporan.project', compact('totals', 'startDate', 'endDate', 'projectArray', 'projectId', 'startDateInput', 'endDateInput'));
}

 public function filterLaporanProject(Request $request)
{
    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
    $projectId = $request->input('project');

    $projectArray = Project::all();

    $bprmsQuery = Bprm::query();

    if ($projectId) {
        $bprmsQuery->where('project', $projectId);
    }

    $bprms = $bprmsQuery->whereBetween('tgl_bprm', [$startDate, $endDate])->get();
    $totals = $this->calculateTotals($bprms);

    return view('laporan.project', compact('totals', 'startDate', 'endDate', 'projectArray'));
}


public function laporanBagian(Request $request)
{
    $projectId = $request->input('project_id');
    $startDateInput = $request->input('start_date');
    $endDateInput = $request->input('end_date');
        $bagian = Bprm::distinct()->pluck('bagian')->toArray();

    $earliestDate = $startDateInput ? Carbon::parse($startDateInput) : Bprm::min('tgl_bprm');
    $latestDate = $endDateInput ? Carbon::parse($endDateInput) : Bprm::max('tgl_bprm');

    $startDate = $earliestDate ? Carbon::parse($earliestDate) : now()->startOfMonth();
    $endDate = $latestDate ? Carbon::parse($latestDate) : now()->endOfMonth();

    $projectArray = Project::pluck('nama_project', 'id');

    $bprmsQuery = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate]);

    if ($projectId) {
        $bprmsQuery->where('project_id', $projectId);
    }

    $bprms = $bprmsQuery->with(['bprmMaterials.material'])->get();

    $totals = $this->calculateTotals($bprms);

    // Ambil data laporan bagian
    $laporanBagian = $bprms->map(function ($bprm) {
        return [
            'kode_material' => $bprm->bprmMaterials->first()->material->kode_material ?? '-',
            'nama_material' => $bprm->bprmMaterials->first()->material->nama ?? '-',
            'spek' => $bprm->bprmMaterials->first()->material->spek ?? '-',
            'total' => $bprm->bprmMaterials->sum('jumlah_material'),
            'project' => $bprm->project_id,
            'tanggal' => $bprm->tgl_bprm,
            'bagian' => $bprm->bagian
        ];
    });

    return view('laporan.bagian', compact('laporanBagian', 'bagian', 'totals', 'startDate', 'endDate', 'projectArray', 'projectId', 'startDateInput', 'endDateInput'));
}



public function filterLaporanBagian(Request $request)
{
    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
    $projectId = $request->input('project');

    $bagian = Bprm::distinct()->pluck('bagian')->toArray();

    $bprmsQuery = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate]);

    if (!empty($bagian)) {
        $bprmsQuery->whereIn('bagian', $bagian);
    }

    if (!empty($projectId)) {
        $bprmsQuery->where('project_id', $projectId);
    }

    $bprms = $bprmsQuery->with(['bprmMaterials.material'])->get();
    $totals = $this->calculateTotals($bprms);

    // Ambil data laporan bagian
    $laporanBagian = $bprms->map(function ($bprm) {
        return [
            'kode_material' => $bprm->bprmMaterials->first()->material->kode_material ?? '-',
            'nama_material' => $bprm->bprmMaterials->first()->material->nama ?? '-',
            'spek' => $bprm->bprmMaterials->first()->material->spek ?? '-',
            'total' => $bprm->bprmMaterials->sum('jumlah_material'),
            'project' => $bprm->project_id,
            'tanggal' => $bprm->tgl_bprm,
            'bagian' => $bprm->bagian
        ];
    });

    $projectArray = Project::pluck('nama_project', 'id');

    return view('laporan.bagian', compact('laporanBagian', 'totals', 'startDate', 'endDate', 'projectArray', 'projectId', 'bagian'));
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



}