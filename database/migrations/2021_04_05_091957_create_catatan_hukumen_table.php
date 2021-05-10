<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanHukumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_hukumen', function (Blueprint $table) {
            $table->bigIncrements('id_catatan_hukuman');
            $table->bigInteger('id_mahasiswa');
            $table->enum('is_dikerjakan', [0, 1]);
            $table->bigInteger('id_semester');
            $table->string('rubah_hukuman');
            $table->text('keterangan');
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
        Schema::dropIfExists('catatan_hukumen');
    }
}
