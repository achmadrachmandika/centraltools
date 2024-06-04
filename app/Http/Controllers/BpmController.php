<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bpm;
use App\Models\Material;
use App\Models\project;
use App\Models\notification;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\project_material;


class BpmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bpms = Bpm::all();
        // Data dari model Notification
        $dataNotifs = Notification::whereNotNull('id')->get();

        // Membuat collection dari data Spm
        $bpmsCollection = collect($bpms);

        // Menggabungkan data Notifikasi ke dalam data Spm berdasarkan id
        $bpmsWithNotifs = $bpmsCollection->map(function ($bpm) use ($dataNotifs) {
            $notif = $dataNotifs->where('no_bpm', $bpm->no_bpm)->first();
            if ($notif) {
                $bpm->status = $notif->status;
                $bpm->id_notif = $notif->id;
            } else {
                $bpm->status = 'seen';
            }
            return $bpm;
        });

        // Mengonversi kembali ke array
        $bpms = $bpmsWithNotifs;

        foreach ($bpms as $bpm){
            $project = project::where('id', $bpm->project)->first();
            $bpm->project = $project->nama_project;
        }

        return view('bpm.index', compact('bpms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kode_materials = Material::all();
        $daftar_projects = project::all();
        return view('bpm.create', compact('kode_materials', 'daftar_projects'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_bpm' => 'required|numeric',
            'project' => 'required|string',
            'bagian' => 'required|string',
            'lokasi' => 'required|string',
            'tgl_permintaan' => 'required|string',
        ]);
        $data = [
            'no_bpm' => $validated['no_bpm'],
            'project' => $validated['project'],
            'bagian' => $validated['bagian'],
            'lokasi' => $validated['lokasi'],
            'tgl_permintaan' => $validated['tgl_permintaan'],
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


        Bpm::create($data);

        $latestBpm = Bpm::latest()->first();

        $id = $latestBpm->id;

        $bpm = Bpm::where('id', $id)->first();

        for ($i = 1; $i <= 10; $i++) {
            $kodeMaterial = 'kode_material_' . $i;
            $jumlahMaterial = 'jumlah_material_' . $i;

            if ($bpm->$kodeMaterial !== NULL) {
                try {
                    $stokMaterial = project_material::where('kode_material', $bpm->$kodeMaterial)->where('kode_project', $data['project'])->first();
                    $stokMaterial = intval($stokMaterial->jumlah);
                    $jumlahMaterial = intval($bpm->$jumlahMaterial);

                    $sum = $stokMaterial + $jumlahMaterial;

                    project_material::where('kode_material', $bpm->$kodeMaterial)->where('kode_project', $data['project'])->update(['jumlah' => $sum]);
                    $jumlahAkhir = project_material::where('kode_material', $bpm->$kodeMaterial)->pluck('jumlah')->sum();

                    Material::where('kode_material', $bpm->$kodeMaterial)->update(['jumlah' => $jumlahAkhir]);
                } catch (Exception $e) {
                    return view('bpm.create')->with('errors', $e);
                }
            }
        }

        return redirect()->route('bpm.index')->with('success', 'BPM created successfully.');
    }

    public function diterima($id)
    {

        return redirect()->route('bpm.index')->with('success', 'Status BPM ' . $id . ' Berubah Menjadi Diterima!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bpm = Bpm::where('id', $id)->first();
        $projectName = project::where('id', $bpm->project)->pluck('nama_project')->first();

        $bpm->project = $projectName;
        return view('bpm.show', compact('bpm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bpm $bpm)
    {
        $kode_materials = Material::all();
        $daftar_projects = project::all();
        return view('bpm.edit', compact('bpm', 'kode_materials', 'daftar_projects'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bpm $bpm)
    {
        $validated = $request->validate([
            'no_spm' => 'required|exists:spms,no_spm',
            'project' => 'required|string',
            'tgl_permintaan' => 'required|string',
        ]);

        $data = [
            'no_spm' => $validated['no_spm'],
            'project' => $validated['project'],
            'tgl_permintaan' => $validated['tgl_permintaan'],
        ];

        $bpm->update($data);
        return redirect()->route('bpm.index')->with('success', 'BPM updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bpm $bpm)
    {
        $bpm->delete();
        return redirect()->route('bpm.index')->with('success', 'BPM deleted successfully.');
    }

    public function searchCodeMaterial(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $project = $request->input('project_id');
            $lokasi = $request->input('lokasi');
            $lokasi = strtolower($lokasi);
            $data = Material::where('kode_material', 'LIKE', "%{$query}%")->where('project', 'LIKE', "%{$project}%")->where('lokasi', $lokasi)->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:absolute;; max-height: 120px; overflow-y: auto;">';

            foreach ($data as $row) {
                $output .= '
                <a href="#" style="text-decoration:none; color:black;">
                    <li data-satuan="' . $row->satuan . '" data-nama="' . $row->nama . '" data-spek="' . $row->spek . '"  style="background-color: white; list-style-type: none; cursor: pointer; padding-left:10px" onmouseover="this.style.backgroundColor=\'grey\'" onmouseout="this.style.backgroundColor=\'initial\'">'
                    . $row->kode_material .
                    '</li>
                </a>
            ';
            }

            $output .= '</ul>';
            echo $output;
        }
    }

    public function searchNoSPM(Request $request)
    {
        if ($request->has('query')) {
            $query = $request->input('query');
            $data = DB::table('spms')
                ->where('no_spm', 'LIKE', "%{$query}%")
                ->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:absolute;margin:-10px 0px 0px 12px; max-height: 120px; overflow-y: auto;">';
            foreach ($data as $row) {
                $output .= '<li ';
                for ($i = 1; $i <= 10; $i++) {
                    $output .= 'data-kode_' . $i . '="' . $row->{'kode_material_' . $i} . '" ';
                    $output .= 'data-nama_' . $i . '="' . $row->{'nama_material_' . $i} . '" ';
                    $output .= 'data-spek_' . $i . '="' . $row->{'spek_material_' . $i} . '" ';
                    $output .= 'data-jumlah_' . $i . '="' . $row->{'jumlah_material_' . $i} . '" ';
                    $output .= 'data-satuan_' . $i . '="' . $row->{'satuan_material_' . $i} . '" ';
                }
                $output .= 'style="background-color: white; list-style-type: none; cursor: pointer; padding-left:10px" onmouseover="this.style.backgroundColor=\'grey\'" onmouseout="this.style.backgroundColor=\'initial\'">'
                    . $row->no_spm .
                    '</li>';
            }

            $output .= '</ul>';
            return $output;
        }
    }
}
