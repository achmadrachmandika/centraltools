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
            $table->id(); // Primary key default Laravel
            $table->unsignedBigInteger('nomor_bprm')->unique(); // Nomor unik
            $table->string('project');
            $table->string('bagian');
            $table->string('nama_admin');
            $table->string('no_spm');
            $table->date('tgl_bprm');
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
