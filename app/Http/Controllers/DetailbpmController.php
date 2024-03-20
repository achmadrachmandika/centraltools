<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade untuk menggunakan query builder

class DetailbpmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lakukan query untuk mendapatkan data yang diinginkan
        $details = DB::table('bprms')
                    ->join('bpms', 'bprms.nomor_bpm', '=', 'bpms.nomor_bpm')
                    ->select('bprms.no_konversi', 'bpms.nomor_bpm', 'bpms.order_proyek', 'bpms.kode_material', 'bpms.jumlah_bpm', 'bpms.tgl_permintaan', 'bpms.keterangan')
                    ->get();

        // Kirim data ke view untuk ditampilkan
        return view('detail.detail_bpm', compact('details'));
    }
}
