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
            $table->integer('dia_fin');
            $table->integer('mes_fin');
            $table->integer('anio_fin');
            $table->integer('dia_comienzo');
            $table->integer('mes_comienzo');
            $table->integer('anio_comienzo');
            $table->string('premio');
            $table->string('reglas');
            $table->integer('max_players');
            $table->integer('estado');
            $table->string('nombre');
            $table->integer('id_modalidad');
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
