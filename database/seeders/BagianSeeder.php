<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bagian;

class BagianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run()
    {
        Bagian::create(['nama_bagian' => 'Fabrikasi-PPL', 'lokasi' => 'fabrikasi']);
        Bagian::create(['nama_bagian' => 'Fabrikasi-PRKB', 'lokasi' => 'fabrikasi']);
        Bagian::create(['nama_bagian' => 'Fabrikasi-PRKT', 'lokasi' => 'fabrikasi']);
        Bagian::create(['nama_bagian' => 'Fabrikasi-Bogie', 'lokasi' => 'fabrikasi']);
        Bagian::create(['nama_bagian' => 'Fabrikasi-Welding 1', 'lokasi' => 'fabrikasi']);

        Bagian::create(['nama_bagian' => 'Fabrikasi-Welding 2', 'lokasi' => 'fabrikasi']);
        Bagian::create(['nama_bagian' => 'Finishing-Interior', 'lokasi' => 'finishing']);
        Bagian::create(['nama_bagian' => 'Finishing-PMK EQ', 'lokasi' => 'finishing']);
        Bagian::create(['nama_bagian' => 'Finishing-PMK Bogie', 'lokasi' => 'finishing']);
        Bagian::create(['nama_bagian' => 'Finishing-Painting', 'lokasi' => 'finishing']);
        Bagian::create(['nama_bagian' => 'Finishing-Piping', 'lokasi' => 'finishing']);
        Bagian::create(['nama_bagian' => 'Finishing-Wiring', 'lokasi' => 'finishing']);

    }



}
