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
            $table->string('no_material_pada_bom');
            $table->string('no');
            $table->string('desc_material');
            $table->string('kode_material');
            $table->string('spek_material');
            $table->integer('qty_fab');
            $table->integer('qty_fin');
            $table->integer('total_material');
            $table->string('satuan_material');
            $table->string('keterangan');
            $table->string('revisi');
            $table->timestamps();

            // $table->foreign('kode_material')->references('kode_material')->on('materials')->onDelete('cascade');
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
