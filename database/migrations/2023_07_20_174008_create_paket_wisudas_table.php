<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketWisudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_wisudas', function (Blueprint $table) {
            $table->id();
            $table->string("thWisuda");
            $table->string("nim");
            $table->string("jurusan");
            $table->string("nama_mahasiswa");
            $table->string("campus");
            $table->string("email")->nullable();
            $table->string("uToga")->nullable();
            $table->string("bukti_pic")->nullable();
            $table->string("skip")->nullable();
            $table->string("status")->default("open");
            $table->string("keterangan")->nullable();
            $table->string("user")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_wisudas');
    }
}
