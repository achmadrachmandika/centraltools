<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data project dummy
        $projects = [
            ['ID_Project' => '60230', 'nama_project' => 'Project Alpha'],
            ['ID_Project' => '60231', 'nama_project' => 'Project Beta'],
            ['ID_Project' => '60232', 'nama_project' => 'Project Gamma'],
            ['ID_Project' => '60233', 'nama_project' => 'Project Delta'],
            ['ID_Project' => '60234', 'nama_project' => 'Project Epsilon'],
            ['ID_Project' => '60235', 'nama_project' => 'Project Zeta'],
            ['ID_Project' => '60236', 'nama_project' => 'Project Eta'],
        ];

        // Insert data ke tabel projects
        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
