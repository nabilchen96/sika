<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarunasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarunas', function (Blueprint $table) {
            $table->bigIncrements('id_mahasiswa');
            $table->string('id_mahasiswa_siakad')->unique();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nama_mahasiswa')->nullable();
            $table->string('nim')->nullable();
            $table->string('id_kelas')->nullable();
            $table->string('nama_kelas')->nullable();
            $table->string('id_prodi')->nullable();
            $table->string('nama_program_studi')->nullable();
            $table->string('semester')->nullable();
            $table->string('agama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->string('wali_dihubungi')->nullable();
            $table->string('no_wali_dihubungi')->nullable();
            $table->string('hubungan_wali')->nullable();
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
        Schema::dropIfExists('tarunas');
    }
}
