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
        Schema::create('project_material_loans_details', function (Blueprint $table) {
            $table->id();
    $table->foreignId('loan_id')->constrained('project_material_loans')->onDelete('cascade');
    $table->foreignId('project_material_id')->constrained('project_materials')->onDelete('cascade');
    $table->integer('jumlah');
    $table->text('keterangan')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_material_loans_details');
    }
};
