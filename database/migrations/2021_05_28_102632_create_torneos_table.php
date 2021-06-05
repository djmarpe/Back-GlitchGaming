<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorneosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('torneos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idJuego');
            $table->integer('diaFin');
            $table->integer('mesFin');
            $table->integer('anioFin');
            $table->integer('diaComienzo');
            $table->integer('mesComienzo');
            $table->integer('anioComienzo');
            $table->integer('equiposInscritos');
            $table->integer('premio');
            $table->tinyInteger('ultimo');
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
        Schema::dropIfExists('torneos');
    }
}
