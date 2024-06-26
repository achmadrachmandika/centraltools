<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Menambahkan kolom deleted_at ke tabel boms
        Schema::table('boms', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Menambahkan kolom deleted_at ke tabel bpms
        Schema::table('bpms', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Menambahkan kolom deleted_at ke tabel bprms
        Schema::table('bprms', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('project_materials', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('sparepart_boms', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('spms', function (Blueprint $table) {
            $table->softDeletes();
        });


        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Menghapus kolom deleted_at dari tabel boms
        Schema::table('boms', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Menghapus kolom deleted_at dari tabel bpms
        Schema::table('bpms', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Menghapus kolom deleted_at dari tabel bprms
        Schema::table('bprms', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('project_materials', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('sparepart_boms', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('spms', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
