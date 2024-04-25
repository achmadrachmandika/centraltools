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
        Schema::create('sparepart_boms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nomor_bom')->unsigned(); 
            $table->string('nama_material')->nullable();
            $table->string('kode_material')->nullable();
            $table->string('spek_material')->nullable();
            $table->integer('jumlah_material')->nullable();
            $table->string('satuan_material')->nullable();
            $table->timestamps();

            $table->foreign('kode_material')->references('kode_material')->on('materials')->onDelete('cascade');
            $table->foreign('nomor_bom')->references('nomor_bom')->on('boms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sparepart_boms');
    }
};
