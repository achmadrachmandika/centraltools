<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade untuk menggunakan query builder

class bomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lakukan query untuk mendapatkan data yang diinginkan
        $details = [];

        // Kirim data ke view untuk ditampilkan
        return view('bom.index', compact('details'));
    }
}
