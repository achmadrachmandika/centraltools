<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('project_material_loan_details', function (Blueprint $table) {
            $table->string('status')->default('dipinjam')->after('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_material_loan_details', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
