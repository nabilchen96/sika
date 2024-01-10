<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDewanKehormatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dewan_kehormatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pejabat');
            $table->string('jabatan');
            $table->string('jabatan_kepanitiaan');
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
        Schema::dropIfExists('dewan_kehormatans');
    }
}
