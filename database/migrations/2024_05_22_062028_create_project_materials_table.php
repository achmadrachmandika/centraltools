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
            $table->string('kode_material'); // Menghilangkan unsigned
            $table->unsignedBigInteger('kode_project');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('kode_material')
                ->references('kode_material')
                ->on('materials')
                ->onDelete('cascade');

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
