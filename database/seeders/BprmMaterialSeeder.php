<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bprm;
use App\Models\Material;
use App\Models\BprmMaterial;

class BprmMaterialSeeder extends Seeder
{
    public function run(): void
    {
        $bprms = Bprm::all();
        $materials = Material::all();
        $satuans = ['pcs', 'meter', 'kg', 'set', 'liter'];

        foreach ($bprms as $bprm) {
            $selectedMaterials = $materials->random(rand(2, 5)); // Ambil 2-5 material per BPRM

            foreach ($selectedMaterials as $material) {
                BprmMaterial::create([
                    'nomor_bprm' => $bprm->nomor_bprm,
                    'material_id' => $material->id,
                    'jumlah_material' => rand(1, 20),
                    'satuan_material' => $satuans[array_rand($satuans)],
                ]);
            }
        }
    }
}
