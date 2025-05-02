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
         Schema::create('boms', function (Blueprint $table) {
            $table->bigIncrements('nomor_bom')->startingValue(121211); // Mengubah menjadi bigIncrements
            $table->string('project', 100);
            $table->date('tgl_permintaan');
            $table->string('keterangan', 150)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boms');
    }
};