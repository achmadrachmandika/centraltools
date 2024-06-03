<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Bprm;
use App\Models\Material;
use Carbon\Carbon;

class LaporanBprmController extends Controller
{

    public function index(Request $request)
{
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

    return view('laporan.index', compact('totals', 'startDate', 'endDate', 'projectArray', 'dates', 'firstWeekDates', 'filterdigunakan'));
}

    public function laporanBagian()
    {
        // // Fetch the earliest and latest dates from the Bprm table
        // $earliestDate = Bprm::min('tgl_bprm');
        // $latestDate = Bprm::max('tgl_bprm');

        // // Parse the dates
        // $startDate = $earliestDate ? Carbon::parse($earliestDate) : null;
        // $endDate = $latestDate ? Carbon::parse($latestDate) : null;

        // $projectArray = Project::all();

        // // Fetch all Bprm records within the date range
        // $bprms = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate])->get();
        // $totals = $this->calculateTotals($bprms);
        
        return 'bagian';
        // return view('laporan.index', compact('totals', 'startDate', 'endDate', 'projectArray'));
    }

    public function laporanProject()
    {
        // // Fetch the earliest and latest dates from the Bprm table
        // $earliestDate = Bprm::min('tgl_bprm');
        // $latestDate = Bprm::max('tgl_bprm');

        // // Parse the dates
        // $startDate = $earliestDate ? Carbon::parse($earliestDate) : null;
        // $endDate = $latestDate ? Carbon::parse($latestDate) : null;

        // $projectArray = Project::all();

        // // Fetch all Bprm records within the date range
        // $bprms = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate])->get();
        // $totals = $this->calculateTotals($bprms);
        
        return 'Project';
        // return view('laporan.index', compact('totals', 'startDate', 'endDate', 'projectArray'));
    }

    public function filterLaporan(Request $request)
{
    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

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

    return view('laporan.index', compact('totals', 'startDate', 'endDate', 'projectArray', 'dates', 'firstWeekDates', 'filterdigunakan'));
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
                    'bagian' => $bprm->bagian
                ];

                $totals[$bprm->$kodeMaterial]['total'] += intval($bprm->$jumlahMaterial);
            }
        }
    }

    return $totals;
    }

       public function laporanBprmBagian(Request $request)
{
    return view('laporan.laporanbagian');
}

    public function laporanBprmProject(Request $request)
{
    return view('laporan.laporanbagian');
}

}
