<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAturanNilaiSamaptasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aturan_nilai_samaptas', function (Blueprint $table) {
            $table->bigIncrements('id_nilai_samapta');
            $table->enum('untuk', ['Taruna', 'Taruni']);
            $table->enum('jenis_samapta', ['Lari', 'Sit-up', 'Push-up', 'Shuttle Run']);
            $table->integer('ukuran_menit');
            $table->float('jumlah');
            $table->integer('nilai');
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
        Schema::dropIfExists('aturan_nilai_samaptas');
    }
}
