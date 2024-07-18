<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_nilais', function (Blueprint $table) {
            $table->bigIncrements('id_rekap_nilai');

            $table->unsignedBigInteger('id_mahasiswa');
            $table->foreign('id_mahasiswa')
                    ->references('id_mahasiswa')
                    ->on('tarunas')
                    ->onDelete('cascade');

            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_semester')
                    ->references('id_semester')
                    ->on('semesters')
                    ->onDelete('cascade');

            $table->float('nilai_samapta');

            $table->float('nilai_softskill');

            $table->float('nilai_pelanggaran');

            $table->float('nilai_penghargaan');

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
        Schema::dropIfExists('rekap_nilais');
    }
}
