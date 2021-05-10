<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanPelanggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_pelanggarans', function (Blueprint $table) {
            $table->bigIncrements('id_catatan_pelanggaran');
            $table->integer('id_mahasiswa');
            $table->integer('id_pelanggaran');
            $table->integer('id_pencatat');
            $table->string('bukti_pelanggaran');
            $table->integer('poin_pelanggaran');
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
        Schema::dropIfExists('catatan_pelanggarans');
    }
}
