<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuentrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuentro', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id_fase');
            $table->bigInteger('id_equipo1');
            $table->bigInteger('id_equipo2');
            $table->bigInteger('resultado_equipo1');
            $table->bigInteger('resultado_equipo2');
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
        Schema::dropIfExists('encuentros');
    }
}
