<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAturanNilaibbisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aturan_nilaibbis', function (Blueprint $table) {
            $table->bigIncrements('id_nilai_bbi');
            $table->integer('bmi');
            $table->enum('untuk', ['Taruna', 'Taruni']);
            $table->enum('stakes', ['Stakes 1', 'Stakes 2', 'Stakes 3', 'Stakes 4']);
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
        Schema::dropIfExists('aturan_nilaibbis');
    }
}
