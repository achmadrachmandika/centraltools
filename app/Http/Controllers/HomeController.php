<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\project;
use App\Models\bom;
use App\Models\Spm;
use App\Models\Bpm;
use App\Models\Bprm;
use App\Models\project_material;
use App\Models\sparepartBom;
use App\Models\User;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon; // Pastikan Anda mengimpor Carbon


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

        // Mendapatkan waktu 17 jam yang lalu dari sekarang
        $time = Carbon::now()->subMonth(3);
    
        // Mendapatkan semua aktivitas yang dibuat lebih dari 17 jam yang lalu
        Activity::where('created_at', '<', $time)->get();

        // Menghapus aktivitas yang usianya lebih dari 17 jam
        Activity::where('created_at', '<', $time)->delete();

        // Mengembalikan view 'admin.index' dengan data yang diperlukan
        return view('admin.index', compact('stokMaterials', 'projects', 'bom', 'spm', 'bpm', 'bprm')); // Mengirimkan variabel $projects ke view
    }

    public function log(){

        $logs = Activity::orderBy('created_at', 'desc')->get();

        // Mendapatkan nama pengguna berdasarkan causer_id
        foreach ($logs as $log) {
            $log->causer_name = User::where('id', $log->causer_id)->pluck('name')->first();
        }

        return view('log',[
            'logs' => $logs
        ]);
    }

    public function trash(){

        $bom = bom::onlyTrashed()->get()->map(function ($item) {
            $item->jenis_model = 'BOM';
            return $item;
        });
        
        $material = Material::onlyTrashed()->get()->map(function ($item) {
            $item->jenis_model = 'Material';
            if($item->foto){
                $item->image_path = 'storage/material/' . $item->foto;
            }
            return $item;
        });
        
        $projects = project::onlyTrashed()->get()->map(function ($item) {
            $item->jenis_model = 'Projects';
            return $item;
        });
        
        $spm = spm::onlyTrashed()->get()->map(function ($item) {
            $item->jenis_model = 'SPM';
            return $item;
        });
        
        $sparepartBom = sparepartBom::onlyTrashed()->get()->map(function ($item) {
            $item->jenis_model = 'Sparepart BOM';
            return $item;
        });
        
        $project_material = project_material::onlyTrashed()->get()->map(function ($item) {
            $item->jenis_model = 'Project Material';
            return $item;
        });
        
        // Gabungkan semua koleksi
        $data = $bom
            ->merge($material)
            ->merge($projects)
            ->merge($project_material)
            ->merge($spm)
            ->merge($sparepartBom);

        // Tampilkan hasil

        // dd(asset('storage/asets/1046.jpg'));

        return view('trash',[
            'data' => $data
        ]);
    }

    public function restore_data($jenis_model, $id){
        // Logika untuk mengembalikan data berdasarkan model dan ID
    switch ($jenis_model) {
        case 'BOM':
            $item = bom::withTrashed()->find($id);
            break;
        case 'Material':
            $item = material::withTrashed()->find($id);
            break;
        case 'Projects':
            $item = project::withTrashed()->find($id);
            break;
        case 'SPM':
            $item = SPM::withTrashed()->find($id);
            break;
        case 'Sparepart BOM':
            $item = sparepartBom::withTrashed()->find($id);
            break;
        case 'Project Material':
            $item = project_material::withTrashed()->find($id);
            break;
        default:
    }

    if ($item) {
        $item->restore();
        return redirect()->back()->with('success', 'Data berhasil dipulihkan!');
    } else {
        return redirect()->back()->with('error', 'Data tidak ditemukan!');
    }
    }

    public function force_delete($jenis_model, $id){
        // Logika untuk mengembalikan data berdasarkan model dan ID
        switch ($jenis_model) {
            case 'BOM':
                $item = bom::withTrashed()->find($id);
                break;
            case 'Material':
                $item = material::withTrashed()->find($id);
                $fotoPath = 'material/' . $item->foto;

        if ($item->foto && Storage::exists($fotoPath)) {
            Storage::delete($fotoPath);
        };
                break;
            case 'Projects':
                $item = project::withTrashed()->find($id);
                break;
            case 'SPM':
                $item = SPM::withTrashed()->find($id);
                break;
            case 'Sparepart BOM':
                $item = sparepartBom::withTrashed()->find($id);
                break;
            case 'Project Material':
                $item = project_material::withTrashed()->find($id);
                break;
            default:
        }

    if ($item) {
        $item->forceDelete();
        return redirect()->back()->with('success', 'Data berhasil dihapus permanen.');
    } else {
        return redirect()->back()->with('error', 'Data tidak ditemukan!');
    }
    }

    public function clearLog(){
        // Mendapatkan waktu 17 jam yang lalu dari sekarang
        $time = Carbon::now()->subMonth();
    
        // Mendapatkan semua aktivitas yang dibuat lebih dari 17 jam yang lalu
        Activity::where('created_at', '<', $time)->get();

        // Menghapus aktivitas yang usianya lebih dari 17 jam
        Activity::where('created_at', '<', $time)->delete();

        return "logs berusia lebih dari 3 bulan telah di delete";

        
    }
}
