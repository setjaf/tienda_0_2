<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idTienda');
            $table->string('marca')->nullable(false);
            $table->longText('descripcion');
            $table->string('imagen')->default('marca_default.png');
            $table->boolean('activo')->nullable(false)->default(true);
            $table->timestamps();

            $table->foreign('idTienda')->references('id')->on('tiendas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcas');
    }
}
