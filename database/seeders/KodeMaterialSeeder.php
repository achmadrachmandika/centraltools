<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use Illuminate\Support\Str;

class KodeMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $namaMaterials = [
            'PNEUMATIC HAND DRILL', 'STEEL PLATE', 'ALUMINUM PROFILE', 'COPPER WIRE', 'WELDING ROD',
            'HYDRAULIC PUMP', 'AIR COMPRESSOR', 'RAIL AXLE', 'BRAKE DISC', 'SUSPENSION SPRING',
            'ELECTRICAL PANEL', 'SEAT FOAM', 'WINDOW FRAME', 'INSULATION SHEET', 'PAINT COATING'
        ];

        $speks = [
            'URYU USG-4S', 'JIS SS400', '6061-T6', 'AWG 12', 'E6013 2.5mm',
            'Bosch 5HP', 'Hitachi 3HP', '45Mn2', 'DIN 15431', 'EN 10270-1',
            'Siemens S7', 'PU Density 40', 'Aluminum Extrusion', 'Rockwool 50mm', 'Epoxy Blue'
        ];

        $satuans = ['pcs', 'meter', 'kg', 'set', 'liter'];

        $lokasis = ['fabrikasi', 'finishing'];
        $projects = ['60230', '60231'];
        $statuses = ['consumables', 'non_consumables'];

        for ($i = 0; $i < 100; $i++) {
            Material::create([
                'kode_material' => 'MTRL-' . strtoupper(Str::random(6)),
                'nama' => $namaMaterials[array_rand($namaMaterials)],
                'spek' => $speks[array_rand($speks)],
                'jumlah' => 0,
                'satuan' => $satuans[array_rand($satuans)],
                'lokasi' => $lokasis[array_rand($lokasis)],
                'project' => $projects[array_rand($projects)],
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}
