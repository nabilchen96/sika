<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianSoftSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_soft_skills', function (Blueprint $table) {
            $table->bigIncrements('id_nilai_softskill');
            
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

            
            $table->unsignedBigInteger('id_komponen_softskill');
            $table->foreign('id_komponen_softskill')
                    ->references('id_komponen_softskill')
                    ->on('komponen_softskills')
                    ->onDelete('cascade');
            
            $table->float('nilai')->nullable();

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
        Schema::dropIfExists('penilaian_soft_skills');
    }
}
