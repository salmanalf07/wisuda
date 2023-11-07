<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcadToPaketWisudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paket_wisudas', function (Blueprint $table) {
            $table->string('acadCareer')->after('nama_mahasiswa')->nullable();
            $table->string('acadGroup')->after('acadCareer')->nullable();
            $table->string('bukti_ttd')->after('bukti_pic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paket_wisudas', function (Blueprint $table) {
            $table->dropColumn('acadCareer');
            $table->dropColumn('acadGroup');
            $table->dropColumn('bukti_ttd');
        });
    }
}
