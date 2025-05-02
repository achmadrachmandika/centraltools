<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bpms', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->string('no_bpm', 100)->unique(); // No BPM unik untuk referensi ke bpm_materials
            $table->string('project', 100);
            // $table->string('bagian');
            $table->date('tgl_permintaan');
             $table->string('lokasi', 100); // Tambahkan kolom lokasi
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpms');
    }

};