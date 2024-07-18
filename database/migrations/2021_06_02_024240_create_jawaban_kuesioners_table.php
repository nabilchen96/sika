<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanKuesionersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_kuesioners', function (Blueprint $table) {
            $table->bigIncrements('id_jawab_kuesioner');
            
            $table->unsignedBigInteger('id_alumni');
            $table->foreign('id_alumni')->references('id_alumni')->on('alumnis');

            $table->unsignedBigInteger('id_detail_kuesioner');
            $table->foreign('id_detail_kuesioner')->references('id_detail_kuesioner')->on('detail_kuesioners');

            $table->string('jawaban');

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
        Schema::dropIfExists('jawaban_kuesioners');
    }
}
