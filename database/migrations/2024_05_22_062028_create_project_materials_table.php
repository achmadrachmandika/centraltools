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
        Schema::create('project_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id'); // Menggunakan id sebagai referensi
            $table->unsignedBigInteger('kode_project');
            $table->integer('jumlah');
            $table->timestamps();

            // Foreign key ke tabel materials menggunakan id
            $table->foreign('material_id')
                ->references('id')
                ->on('materials')
                ->onDelete('cascade');

            // Foreign key ke tabel projects
            $table->foreign('kode_project')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_materials');
    }
};
