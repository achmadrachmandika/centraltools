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
            $table->bigIncrements('nomor_bpm'); // Mengubah menjadi bigIncrements
            $table->string('order_proyek');
            $table->string('kode_material'); // Kolom kode_material sebagai foreign key
            $table->foreign('kode_material')->references('kode_material')->on('kode_materials')->onDelete('cascade');
            $table->integer('jumlah_bpm');
            $table->enum('satuan', ['pcs', 'kg', 'set']);
            $table->date('tgl_permintaan');
            $table->string('keterangan');
            $table->timestamps();
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
