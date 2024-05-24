<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bpm;
use App\Models\Bprm;
use App\Models\Material;
use Carbon\Carbon;

class LaporanBprmController extends Controller
{
    public function index()
    {
        $bprms = Bprm::all();
        $totals = $this->calculateTotals($bprms);
        return view('laporan.index', compact('totals'));
    }

    public function filterLaporan(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        $bprms = Bprm::whereBetween('tgl_bprm', [$startDate, $endDate])->get();
        $totals = $this->calculateTotals($bprms);

        return view('laporan.index', compact('totals'));
    }

    public function calculateTotals($bprms)
    {
        $totals = [];

        foreach ($bprms as $bprm) {
            for ($i = 1; $i <= 10; $i++) {
                $kodeMaterial = 'kode_material_' . $i;
                $jumlahMaterial = 'jumlah_material_' . $i;
                $namaMaterial = 'nama_material_' . $i;

                if (!empty($bprm->$kodeMaterial) && !empty($bprm->$jumlahMaterial)) {
                    if (!isset($totals[$bprm->$kodeMaterial])) {
                        $totals[$bprm->$kodeMaterial] = [
                            'nama_material' => $bprm->$namaMaterial,
                            'total' => 0,
                            'projects' => [],
                            'bagian' => []
                        ];
                    }

                    $totals[$bprm->$kodeMaterial]['projects'][] = [
                        'project' => $bprm->project,
                        'jumlah' => intval($bprm->$jumlahMaterial),
                        'bagian' => $bprm->bagian
                    ];

                    $totals[$bprm->$kodeMaterial]['total'] += intval($bprm->$jumlahMaterial);
                }
            }
        }

        return $totals;
    }
}
