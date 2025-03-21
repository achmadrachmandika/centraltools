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
            $table->string('no_bpm');
            $table->string('project');
            $table->string('bagian');
            $table->date('tgl_permintaan');
            $table->string('nama_material_1')->nullable();
            $table->string('kode_material_1')->nullable();
            $table->string('spek_material_1')->nullable();
            $table->integer('jumlah_material_1')->nullable();
            $table->string('satuan_material_1')->nullable();
            $table->string('nama_material_2')->nullable();
            $table->string('kode_material_2')->nullable();
            $table->string('spek_material_2')->nullable();
            $table->integer('jumlah_material_2')->nullable();
            $table->string('satuan_material_2')->nullable();
            $table->string('nama_material_3')->nullable();
            $table->string('kode_material_3')->nullable();
            $table->string('spek_material_3')->nullable();
            $table->integer('jumlah_material_3')->nullable();
            $table->string('satuan_material_3')->nullable();
            $table->string('nama_material_4')->nullable();
            $table->string('kode_material_4')->nullable();
            $table->string('spek_material_4')->nullable();
            $table->integer('jumlah_material_4')->nullable();
            $table->string('satuan_material_4')->nullable();
            $table->string('nama_material_5')->nullable();
            $table->string('kode_material_5')->nullable();
            $table->string('spek_material_5')->nullable();
            $table->integer('jumlah_material_5')->nullable();
            $table->string('satuan_material_5')->nullable();
            $table->string('nama_material_6')->nullable();
            $table->string('kode_material_6')->nullable();
            $table->string('spek_material_6')->nullable();
            $table->integer('jumlah_material_6')->nullable();
            $table->string('satuan_material_6')->nullable();
            $table->string('nama_material_7')->nullable();
            $table->string('kode_material_7')->nullable();
            $table->string('spek_material_7')->nullable();
            $table->integer('jumlah_material_7')->nullable();
            $table->string('satuan_material_7')->nullable();
            $table->string('nama_material_8')->nullable();
            $table->string('kode_material_8')->nullable();
            $table->string('spek_material_8')->nullable();
            $table->integer('jumlah_material_8')->nullable();
            $table->string('satuan_material_8')->nullable();
            $table->string('nama_material_9')->nullable();
            $table->string('kode_material_9')->nullable();
            $table->string('spek_material_9')->nullable();
            $table->integer('jumlah_material_9')->nullable();
            $table->string('satuan_material_9')->nullable();
            $table->string('nama_material_10')->nullable();
            $table->string('kode_material_10')->nullable();
            $table->string('spek_material_10')->nullable();
            $table->integer('jumlah_material_10')->nullable();
            $table->string('satuan_material_10')->nullable();
            $table->timestamps();

            $table->foreign('kode_material_1')->references('kode_material')->on('materials')->onDelete('cascade');
            $table->foreign('kode_material_2')->references('kode_material')->on('materials')->onDelete('cascade');
            $table->foreign('kode_material_3')->references('kode_material')->on('materials')->onDelete('cascade');
            $table->foreign('kode_material_4')->references('kode_material')->on('materials')->onDelete('cascade');
            $table->foreign('kode_material_5')->references('kode_material')->on('materials')->onDelete('cascade');
            $table->foreign('kode_material_6')->references('kode_material')->on('materials')->onDelete('cascade');
            $table->foreign('kode_material_7')->references('kode_material')->on('materials')->onDelete('cascade');
            $table->foreign('kode_material_8')->references('kode_material')->on('materials')->onDelete('cascade');
            $table->foreign('kode_material_9')->references('kode_material')->on('materials')->onDelete('cascade');
            $table->foreign('kode_material_10')->references('kode_material')->on('materials')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpms');
    }
};