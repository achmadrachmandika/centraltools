<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = project::latest()->paginate(100);
        // Kirim data ke view untuk ditampilkan
        return view('project.index', compact('projects'));
    }

    public function create()
    {

        // Kirim data ke view untuk ditampilkan
        return view('project.create',);
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

        return redirect()->route('project.index')->with('success', 'Project stored successfully.');
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

    return redirect()->route('project.index')->with('success', 'Project updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {  
        project::where('id',$id)->delete();

        return redirect()->route('project.index')->with('success', 'Project deleted successfully.');
    }
}

