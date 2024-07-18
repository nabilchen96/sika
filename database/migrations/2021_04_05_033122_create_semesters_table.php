<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->bigIncrements('id_semester');
            $table->integer('id_semester_siakad');
            $table->string('tahun_ajaran');
            $table->string('nama_semester');
            $table->enum('a_periode_aktif', [0, 1])->default(0);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('is_semester_aktif')->nullable();
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
        Schema::dropIfExists('semesters');
    }
}
