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
        Schema::create('materials', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('kode_material', 100);
            $table->string('nama', 100);
            $table->string('spek', 150);
            $table->integer('jumlah')->default(0); // Ubah jumlah jadi integer
            $table->string('satuan', 50);
            $table->string('lokasi', 50);
            $table->string('project', 100);
            $table->string('status', 25);
            $table->timestamps();
   

            // Aturan unik: kombinasi kode_material + lokasi
            $table->unique(['kode_material', 'lokasi']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
