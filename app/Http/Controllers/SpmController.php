<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spm;
use App\Models\Material;
use App\Models\project;
use App\Models\notification;
use App\Models\Bagian;

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
    // Data dari model Spm dengan pagination
    $spms = Spm::latest()->paginate(2); // Menampilkan 2 data per halaman

    // Data dari model Notification
    $dataNotifs = Notification::whereNotNull('no_spm')->get();

    // Menggabungkan data Notifikasi ke dalam data Spm berdasarkan no_spm
    $spms->getCollection()->transform(function ($spm) use ($dataNotifs) {
        $notif = $dataNotifs->where('no_spm', $spm->no_spm)->first();
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
        $validated = $request->validate([
            'project' => 'required|string',
             'bagian' => 'required|string|exists:bagians,nama_bagian',
            'nama_admin' => 'required|string',
            'tgl_spm' => 'required|date',
            'keterangan_spm' => 'required|string'
        ]);

        $data = [
            'project' => $validated['project'],
            'bagian' => $validated['bagian'],
            'nama_admin' => $validated['nama_admin'],
            'tgl_spm' => $validated['tgl_spm'],
            'keterangan_spm' => $validated['keterangan_spm'],
            'nama_material_1' => $request->nama_material_1,
            'kode_material_1' => $request->kode_material_1,
            'spek_material_1' => $request->spek_material_1,
            'jumlah_material_1' => $request->jumlah_material_1,
            'satuan_material_1' => $request->satuan_material_1,
            'nama_material_2' => $request->nama_material_2,
            'kode_material_2' => $request->kode_material_2,
            'spek_material_2' => $request->spek_material_2,
            'jumlah_material_2' => $request->jumlah_material_2,
            'satuan_material_2' => $request->satuan_material_2,
            'nama_material_3' => $request->nama_material_3,
            'kode_material_3' => $request->kode_material_3,
            'spek_material_3' => $request->spek_material_3,
            'jumlah_material_3' => $request->jumlah_material_3,
            'satuan_material_3' => $request->satuan_material_3,
            'nama_material_4' => $request->nama_material_4,
            'kode_material_4' => $request->kode_material_4,
            'spek_material_4' => $request->spek_material_4,
            'jumlah_material_4' => $request->jumlah_material_4,
            'satuan_material_4' => $request->satuan_material_4,
            'nama_material_5' => $request->nama_material_5,
            'kode_material_5' => $request->kode_material_5,
            'spek_material_5' => $request->spek_material_5,
            'jumlah_material_5' => $request->jumlah_material_5,
            'satuan_material_5' => $request->satuan_material_5,
            'nama_material_6' => $request->nama_material_6,
            'kode_material_6' => $request->kode_material_6,
            'spek_material_6' => $request->spek_material_6,
            'jumlah_material_6' => $request->jumlah_material_6,
            'satuan_material_6' => $request->satuan_material_6,
            'nama_material_7' => $request->nama_material_7,
            'kode_material_7' => $request->kode_material_7,
            'spek_material_7' => $request->spek_material_7,
            'jumlah_material_7' => $request->jumlah_material_7,
            'satuan_material_7' => $request->satuan_material_7,
            'nama_material_8' => $request->nama_material_8,
            'kode_material_8' => $request->kode_material_8,
            'spek_material_8' => $request->spek_material_8,
            'jumlah_material_8' => $request->jumlah_material_8,
            'satuan_material_8' => $request->satuan_material_8,
            'nama_material_9' => $request->nama_material_9,
            'kode_material_9' => $request->kode_material_9,
            'spek_material_9' => $request->spek_material_9,
            'jumlah_material_9' => $request->jumlah_material_9,
            'satuan_material_9' => $request->satuan_material_9,
            'nama_material_10' => $request->nama_material_10,
            'kode_material_10' => $request->kode_material_10,
            'spek_material_10' => $request->spek_material_10,
            'jumlah_material_10' => $request->jumlah_material_10,
            'satuan_material_10' => $request->satuan_material_10,

        ];

        $latestSpm = Spm::create($data)->no_spm;

        Notification::create([
            'no_spm' => $latestSpm,
            'message' => 'Data baru masuk!'
        ]);
        

        return redirect()->route('spm.index')->with('success', 'SPM created successfully.');
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
