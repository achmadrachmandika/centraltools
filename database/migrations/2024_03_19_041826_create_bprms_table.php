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
        Schema::create('bprms', function (Blueprint $table) {
            $table->string('no_konversi')->primary(); // Mengubah ke primary key
            $table->bigInteger('nomor_bpm')->unsigned(); // Tambahkan kolom nomor_bpm
            $table->foreign('nomor_bpm')->references('nomor_bpm')->on('bpms')->onDelete('cascade');
            $table->string('oka');
            $table->bigInteger('no_bprm');
            $table->double('jumlah_bprm');
            $table->date('tgl_bprm');
            $table->bigInteger('head_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bprms');
    }
};


