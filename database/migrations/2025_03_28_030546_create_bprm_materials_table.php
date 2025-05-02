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
        Schema::create('bprm_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nomor_bprm'); // Pastikan tipe data cocok dengan bprms
            $table->unsignedBigInteger('material_id');
            $table->integer('jumlah_material');
            $table->string('satuan_material', 50)->nullable();
            $table->timestamps();

            // Foreign key dengan tipe data yang sesuai
            $table->foreign('nomor_bprm')->references('nomor_bprm')->on('bprms')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bprm_materials');
    }
};


