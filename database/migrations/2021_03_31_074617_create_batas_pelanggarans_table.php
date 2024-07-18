<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatasPelanggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batas_pelanggarans', function (Blueprint $table) {
            $table->bigIncrements('id_batas_pelanggaran');
            $table->string('tingkat');
            $table->enum('periode', ['Bulanan', 'Semester']);
            $table->integer('batas_kritis');
            $table->integer('batas_maksimal');
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
        Schema::dropIfExists('batas_pelanggarans');
    }
}
