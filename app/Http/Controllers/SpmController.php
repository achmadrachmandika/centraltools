<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spm;
use App\Models\Material;
use App\Models\project;
use App\Models\notification;
use App\Models\Bagian;
use App\Models\SpmMaterial;

use Illuminate\Support\Facades\Bus;

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Collection;

class SpmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    // Data from model Spm with pagination
    $spms = Spm::latest()->paginate(10); // Example: 10 records per page

    // Fetch only relevant notifications based on no_spm
    $noSpmList = $spms->pluck('no_spm')->toArray();
    $dataNotifs = Notification::whereIn('no_spm', $noSpmList)->get();

    // Create a map of notifications for quick lookup
    $notifMap = $dataNotifs->keyBy('no_spm');

    // Merge notification data into Spm records
    $spms->getCollection()->transform(function ($spm) use ($notifMap) {
        $notif = $notifMap->get($spm->no_spm);
        if ($notif) {
            $spm->status = $notif->status;
            $spm->id_notif = $notif->id;
        } else {
            $spm->status = 'seen';
        }
        return $spm;
    });

    return view('spm.index', compact('spms'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kode_materials = Material::all();
        $daftar_projects = project::all();
          $bagians = Bagian::all();
        return view('spm.create', compact('kode_materials', 'daftar_projects', 'bagians'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    // Validasi input dari form
    $validated = $request->validate([
        'project' => 'required|string',
        'bagian' => 'required|string|exists:bagians,nama_bagian',
        'nama_admin' => 'required|string',
        'tgl_spm' => 'required|date',
        'keterangan_spm' => 'required|string',

        // Validasi array material
        'materials.*.kode_material' => 'required|string|exists:materials,kode_material',
        'materials.*.spek_material' => 'nullable|string',
        'materials.*.jumlah_material' => 'required|numeric|min:1',
        'materials.*.satuan_material' => 'required|string',
    ]);

    // Simpan data utama SPM
    $spm = Spm::create([
        'project' => $validated['project'],
        'bagian' => $validated['bagian'],
        'nama_admin' => $validated['nama_admin'],
        'tgl_spm' => $validated['tgl_spm'],
        'keterangan_spm' => $validated['keterangan_spm'],
    ]);

    // Simpan data material terkait
    if ($request->has('materials') && is_array($request->materials)) {
        foreach ($request->materials as $material) {
            SpmMaterial::create([
                'no_spm' => $spm->no_spm,
                'kode_material' => $material['kode_material'],
                'spek_material' => $material['spek_material'] ?? null,
                'jumlah_material' => $material['jumlah_material'],
                'satuan_material' => $material['satuan_material'],
            ]);
        }
    } else {
        return redirect()->back()->withErrors('Data material tidak ditemukan.');
    }

    // Buat notifikasi
    Notification::create([
        'no_spm' => $spm->no_spm,
        'message' => 'Data baru masuk!',
    ]);

    return redirect()->route('spm.index')->with('success', 'SPM berhasil dibuat.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id, $id_notif)
    {
        $spm = Spm::where('no_spm', $id)->first();
        if (!$spm) {
            return redirect()->route('spm.index')->with('error', 'SPM not found.');
        }

        $projectName = project::where('id', $spm->project)->pluck('nama_project')->first();

        $spm->project = $projectName;

        $notification = Notification::where('id', $id_notif)->first();
        if ($notification) {
            $notification->status = 'seen';
            $notification->update();
        }
        return view('spm.show', compact('spm'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spm $spm)
    {

        $kode_materials = Material::all();
        $daftar_projects = project::all();
        return view('spm.edit', compact('spm', 'kode_materials', 'daftar_projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'project' => 'required|string',
            'tgl_spm' => 'required|date',
            'keterangan_spm' => 'required|string'
        ]);


        $data = [

            'project' => $validated['project'],
            'tgl_spm' => $validated['tgl_spm'],
            'keterangan_spm' => $validated['keterangan_spm']
        ];

        // Anda harus mendapatkan objek Spm dari database sebelum Anda dapat memperbarui data
        $spm = Spm::findOrFail($id);
        $spm->update($data);

        return redirect()->route('spm.index')->with('success', 'SPM updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spm $spm)
    {
        $spm->delete();
        return redirect()->route('spm.index')->with('success', 'SPM deleted successfully.');
    }

   public function searchCodeMaterial(Request $request)
{
    if ($request->has('query')) {
        $query = $request->input('query');
        $project = $request->input('project_id');
        $lokasi = trim(strtolower($request->input('lokasi'))); // Normalize lokasi input

        // Fetch data based on the search query and filters
        $data = Material::where('kode_material', 'LIKE', "%{$query}%")
                        ->where('project', 'LIKE', "%{$project}%")
                        ->where('lokasi', $lokasi)
                        ->get();

        // Check if no data was found and return a "not found" message
        if ($data->isEmpty()) {
            return response()->json('<ul class="dropdown-menu" style="display:block; position:absolute; max-height: 120px; overflow-y: auto;"><li style="padding:10px; color:grey;">Tidak ditemukan</li></ul>');
        }

        // Generate the dropdown list output
        $output = '<ul class="dropdown-menu" style="display:block; position:absolute; max-height: 120px; overflow-y: auto;">';
        foreach ($data as $row) {
            $output .= '
            <li data-satuan="' . $row->satuan . '" 
                data-nama="' . $row->nama . '" 
                data-spek="' . $row->spek . '"  
                data-lokasi="' . $row->lokasi . '"
                style="background-color: white; list-style-type: none; cursor: pointer; padding:10px;"
                onmouseover="this.style.backgroundColor=\'grey\'" 
                onmouseout="this.style.backgroundColor=\'initial\'">'
                . $row->kode_material . '
            </li>';
        }
        $output .= '</ul>';

        // Return the generated HTML response
        return response()->json($output);
    }
}

}
