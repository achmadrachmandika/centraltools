<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bprm;
use App\Models\Project;
use App\Models\Bagian;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BprmSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::pluck('ID_Project')->toArray();
        $bagians = Bagian::pluck('nama_bagian')->toArray(); // Ambil nama bagian dari tabel
        $admins = ['Dina', 'Budi', 'Agus', 'Rina'];

        for ($i = 0; $i < 20; $i++) {
            Bprm::create([
                'nomor_bprm' => 70000 + $i,
                'project' => $projects[array_rand($projects)],
                'bagian' => $bagians[array_rand($bagians)],
                'nama_admin' => $admins[array_rand($admins)],
                'no_spm' => 'SPM-' . strtoupper(Str::random(5)),
                'tgl_bprm' => Carbon::now()->subDays(rand(1, 60)),
            ]);
        }
    }
}
