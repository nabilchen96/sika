<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanSakitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_sakits', function (Blueprint $table) {
            $table->bigIncrements('id_catatan_sakit');
            $table->date('tgl_sakit');
            $table->text('keterangan_sakit');
            $table->string('surat_sakit');
            $table->integer('id_mahasiswa');
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
        Schema::dropIfExists('catatan_sakits');
    }
}
