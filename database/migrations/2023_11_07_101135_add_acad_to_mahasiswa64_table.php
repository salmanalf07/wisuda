<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcadToMahasiswa64Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mahasiswa64', function (Blueprint $table) {
            $table->string('acadCareer')->after('nama_mahasiswa')->nullable();
            $table->string('acadGroup')->after('acadCareer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswa64', function (Blueprint $table) {
            $table->dropColumn('acadCareer');
            $table->dropColumn('acadGroup');
        });
    }
}
