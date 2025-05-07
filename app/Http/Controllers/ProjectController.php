<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = project::all();
        // Kirim data ke view untuk ditampilkan
        return view('project.index', compact('projects'));
    }

    public function create()
    {

        // Kirim data ke view untuk ditampilkan
        return view('project.create',);
    }

    public function getData(Request $request)
{
    // return view('auth.login');
    $data = project::select(['id', 'ID_Project', 'nama_project']);
    // dd($data);
    // $data = Bagian::all();

    // return response()->json(['data' => $data]);
    
    return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'ID_Project' => 'required|string',
            'project' => 'required|string',
        ]);

        // Assuming your Project model is named 'Project'
           project::create([
        'ID_Project' => $validated['ID_Project'],
        'nama_project' => $validated['project'],
    ]);

        return redirect()->route('project.index')->with('success', 'Project berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
     public function edit($id)
{     
    $project = project::where('id', $id)->first();;
    return view('project.edit', compact('project'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'ID_Project' => 'required|string',
        'project' => 'required|string',
    ]);

    // Assuming your Project model is named 'Project'
    Project::where('id', $id)->update([
        'ID_Project' => $validated['ID_Project'],
        'nama_project' => $validated['project']
    ]);

    return redirect()->route('project.index')->with('success', 'Project berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {  
    //     project::where('id',$id)->delete();

    //     return redirect()->route('project.index')->with('success', 'Project berhasil dihapus.');
    // }

   public function destroy(string $id)
{
    try {
        $project = Project::findOrFail($id);
        $projectId = $project->id;
        $project->delete();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Project ' . $projectId . ' berhasil dihapus.'
            ]);
        }
        
        return redirect()->route('project.index')->with('success', 'Project berhasil dihapus.');
    } catch (\Exception $e) {
        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
        
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
    }
}
}

