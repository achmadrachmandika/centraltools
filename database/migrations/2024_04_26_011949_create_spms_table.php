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
        Schema::create('spms', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_konversi')->unique(); // Tambahkan kolom nomor_konversi dengan tipe string dan unik
            $table->string('no_spm');
            $table->string('nama_project');
            $table->string('kode_material');
            $table->string('spek');
            $table->string('satuan');
            $table->string('no_cp');
            $table->integer('jumlah_spm');
            $table->date('tgl_spm');
            $table->text('keterangan_spm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spms');
    }
};

