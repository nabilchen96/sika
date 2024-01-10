<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanPenghargaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_penghargaans', function (Blueprint $table) {
            $table->bigIncrements('id_catatan_penghargaan');
            $table->date('tgl_penghargaan');
            $table->integer('id_penghargaan');
            $table->integer('id_mahasiswa');
            $table->integer('id_semester');
            $table->string('sk_penghargaan');
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
        Schema::dropIfExists('catatan_penghargaans');
    }
}
