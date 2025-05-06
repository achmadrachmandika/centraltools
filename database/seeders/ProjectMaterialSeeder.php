<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\Project;
use App\Models\project_material;

class ProjectMaterialSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all(); // Pastikan ini ada
        $materials = Material::all();

        foreach ($materials as $material) {
    $selectedProjects = $projects->random(rand(1, 2));
    $total = 0;

    foreach ($selectedProjects as $project) {
        $jumlah = rand(1, 50);
        $total += $jumlah;

        project_material::create([
            'material_id' => $material->id,
            'kode_project' => $project->id,
            'jumlah' => $jumlah,
        ]);
    }

    // Update total jumlah ke tabel materials
    $material->update(['jumlah' => $total]);
}

    }
}
