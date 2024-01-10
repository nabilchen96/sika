<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerizinansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perizinans', function (Blueprint $table) {
            $table->bigIncrements('id_catatan_perizinan');
            $table->integer('id_mahasiswa');
            $table->date('tgl_izin_keluar');
            $table->date('tgl_izin_kembali')->nullable();
            $table->integer('id_semester');
            $table->text('keterangan_izin');
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
        Schema::dropIfExists('perizinans');
    }
}
