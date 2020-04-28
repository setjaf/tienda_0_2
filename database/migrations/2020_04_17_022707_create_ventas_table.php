<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idTienda')->nullable(false);
            $table->foreignId('idUsuario')->nullable(false);
            $table->float('importe')->nullable(false);
            $table->dateTime('fecha')->nullable(false);
            $table->timestamps();

            $table->foreign('idTienda')->references('id')->on('tiendas');
            $table->foreign('idUsuario')->references('id')->on('usuarios');
        });


        Schema::create('producto_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idVenta')->nullable(false);
            $table->foreignId('idProducto')->nullable(false);
            $table->float('precioFinal')->nullable(false);
            $table->dateTime('PrecioVenta')->nullable(false);
            $table->timestamps();

            $table->foreign('idVenta')->references('id')->on('ventas');
            $table->foreign('idProducto')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
