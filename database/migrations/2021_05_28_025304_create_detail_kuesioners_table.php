<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailKuesionersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_kuesioners', function (Blueprint $table) {
            $table->bigIncrements('id_detail_kuesioner');
            
            $table->unsignedBigInteger('id_kuesioner');
            $table->foreign('id_kuesioner')->references('id_kuesioner')->on('kuesioners');

            $table->text('soal');
            $table->string('jenis_soal');
            $table->text('jawaban');
            
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
        Schema::dropIfExists('detail_kuesioners');
    }
}
