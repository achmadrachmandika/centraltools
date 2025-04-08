<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bagians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bagian');
            $table->string('lokasi'); // disesuaikan dengan kolom lokasi di tabel materials
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bagians');
    }
};
