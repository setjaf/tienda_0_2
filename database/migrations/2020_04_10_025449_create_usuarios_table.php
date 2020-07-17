<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPersona');
            $table->foreignId('idRol');
            $table->string('email')->nullable(false)->unique();
            $table->string('password')->nullable(false);
            $table->boolean('activo')->nullable(false)->default(true);
            $table->string('imagen')->default('usuario_default.png');
            $table->string('remember_token',100)->nullable(true)->default(null);
            $table->dateTime('email_verified_at')->nullable(true)->default(null);
            $table->timestamps();

            $table->foreign('idPersona')->references('id')->on('personas');
            $table->foreign('idRol')->references('id')->on('rols');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
