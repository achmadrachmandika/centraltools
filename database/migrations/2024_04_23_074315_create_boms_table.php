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
            $table->string('project');
            $table->date('tgl_permintaan');
            $table->string('keterangan')->nullable();
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