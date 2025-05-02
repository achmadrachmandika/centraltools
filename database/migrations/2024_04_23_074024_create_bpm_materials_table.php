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
        Schema::create('bpm_materials', function (Blueprint $table) {
            $table->id();
            $table->string('no_bpm', 100); // Menyesuaikan dengan bpms yang menggunakan string untuk no_bpm
               $table->unsignedBigInteger('material_id');
            $table->integer('jumlah_material');
            $table->string('satuan_material')->nullable();
            $table->timestamps();

            // Foreign key ke tabel bpms berdasarkan no_bpm
            $table->foreign('no_bpm')->references('no_bpm')->on('bpms')->onDelete('cascade');

            // Foreign key ke tabel materials berdasarkan material_id
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpm_materials');
    }
};
