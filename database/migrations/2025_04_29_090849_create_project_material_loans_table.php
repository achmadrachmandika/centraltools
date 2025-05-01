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
        Schema::create('project_material_loans', function (Blueprint $table) {
              $table->id();
    $table->foreignId('project_peminjam_id')->constrained('projects')->onDelete('cascade');
    $table->foreignId('project_pemilik_id')->constrained('projects')->onDelete('cascade');
    $table->date('tanggal_pinjam');
    $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
    $table->date('tanggal_dikembalikan')->nullable();
    $table->text('keterangan')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_material_loans');
    }
};
