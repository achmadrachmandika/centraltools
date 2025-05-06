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
        Schema::create('spm_materials', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('no_spm');
    $table->string('kode_material');
    $table->string('spek_material')->nullable();
    $table->integer('jumlah_material')->nullable();
    $table->string('satuan_material')->nullable();
    $table->timestamps();

    $table->foreign('no_spm')->references('no_spm')->on('spms')->onDelete('cascade');
    $table->foreign('kode_material')->references('kode_material')->on('materials')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
