<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_gastos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idTienda');
            $table->string('nombre')->nullable(false);
            $table->longText('descripcion');
            $table->string('color',7)->nullable(false);
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
        Schema::dropIfExists('tipo_gastos');
    }
}
