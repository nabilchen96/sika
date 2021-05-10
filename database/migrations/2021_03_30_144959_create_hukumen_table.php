<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHukumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hukumen', function (Blueprint $table) {
            $table->bigIncrements('id_hukuman');
            $table->string('kategori_hukuman');
            //hukuman ringan
            //hukuman sedang
            //hukuman berat
            //hukuman khusus
            //hukuman batas kritis bulan
            //hukuman batas maksimal bulanan
            //hukuman batas kritis semester
            //hukuman batas maksimal semester
            $table->text('hukuman');
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
        Schema::dropIfExists('hukumen');
    }
}
