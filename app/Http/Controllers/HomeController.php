<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\project;
use App\Models\bom;
use App\Models\Spm;
use App\Models\Bpm;
use App\Models\Bprm;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    // Mengambil semua data stok material
    $stokMaterials = Material::all(); 
    $projects = Project::all(); // Mengambil semua data project
    $bom = bom::all();
    $spm = Spm::all();
    $bpm = Bpm::all();
    $bprm = Bprm::all();

    // Mengembalikan view 'admin.index' dengan data yang diperlukan
    return view('admin.index', compact('stokMaterials', 'projects', 'bom', 'spm', 'bpm', 'bprm')); // Mengirimkan variabel $projects ke view
}
}
