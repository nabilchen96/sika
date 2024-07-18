<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLamaranKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lamaran_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelamar')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('nomor_telpon')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
            $table->text('pengalaman')->nullable();
            $table->string('upload_lamaran')->nullable();
            $table->string('id_berita')->nullable();
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
        Schema::dropIfExists('lamaran_kerjas');
    }
}
