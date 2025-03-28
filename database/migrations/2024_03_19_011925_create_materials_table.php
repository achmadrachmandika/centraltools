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
            $table->string('kode_material');
            $table->string('nama');
            $table->string('spek');
            $table->integer('jumlah')->default(0); // Ubah jumlah jadi integer
            $table->string('satuan');
            $table->string('lokasi');
            $table->string('project');
            $table->string('status');
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
