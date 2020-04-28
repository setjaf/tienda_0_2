<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUsuario');
            $table->string('nombre')->nullable(false);
            $table->string('calle');
            $table->string('numero');
            $table->string('cp',5);
            $table->float('balance')->nullable(false)->default(0);
            $table->string('imagen')->default('default_tienda.jpg');
            $table->boolean('activo')->nullable(false)->default(true);
            $table->timestamps();

            $table->foreign('idUsuario')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiendas');
    }
}
