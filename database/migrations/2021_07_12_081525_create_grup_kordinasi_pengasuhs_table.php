<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupKordinasiPengasuhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grup_kordinasi_pengasuhs', function (Blueprint $table) {
            $table->bigIncrements('id_grup_kordinasi_pengasuh');

            $table->unsignedBigInteger('id_kordinator_pengasuh');
            $table->foreign('id_kordinator_pengasuh')
                    ->references('id_kordinator_pengasuh')
                    ->on('kordinator_pengasuhs')
                    ->onDelete('cascade');
            
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('grup_kordinasi_pengasuhs');
    }
}
