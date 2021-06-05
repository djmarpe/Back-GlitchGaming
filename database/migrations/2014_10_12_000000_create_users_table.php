<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 255);
            $table->string('apellidos', 255);
            $table->tinyInteger('edad');
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('pais', 255);
            $table->string('nombreUsuario', 255)->unique();
            $table->tinyInteger('estado');
            $table->tinyInteger('verificado');
            $table->string('descripcion', 2000);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
