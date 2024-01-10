<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianSamaptasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_samaptas', function (Blueprint $table) {
            $table->bigIncrements('id_nilai_samapta');
            
            $table->unsignedBigInteger('id_mahasiswa');
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('tarunas')->onDelete('cascade');

            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_semester')->references('id_semester')->on('semesters')->onDelete('cascade');
            
            $table->float('jarak_lari');
            $table->float('nilai_lari');

            $table->float('jumlah_push_up');
            $table->float('nilai_push_up');

            $table->float('jumlah_sit_up');
            $table->float('nilai_sit_up');

            $table->float('jumlah_shuttle_run');
            $table->float('nilai_shuttle_run');

            $table->float('tinggi_badan');
            $table->float('berat_badan');
            $table->float('nilai_samapta');

            $table->string('stakes');
            $table->float('nilai_bbi');

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
        Schema::dropIfExists('penilaian_samaptas');
    }
}
