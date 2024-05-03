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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('no_spm')->nullable();
            $table->unsignedBigInteger('no_bprm')->nullable();
            $table->unsignedBigInteger('no_bpm')->nullable();
            $table->string('message');
            $table->string('status')->default('unread'); // Kolom status dengan default 'unread'
            $table->timestamps();
            $table->foreign('no_spm')->references('no_spm')->on('spms')->onDelete('cascade');
            $table->foreign('no_bprm')->references('nomor_bprm')->on('bprms')->onDelete('cascade');
            $table->foreign('no_bpm')->references('id')->on('bpms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
