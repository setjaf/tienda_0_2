<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_proveedors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idTienda');
            $table->foreignId('idUsuario');
            $table->foreignId('idProveedor');
            $table->dateTime('fechaPedido');
            $table->boolean('atendido')->default(false);
            $table->timestamps();

            $table->foreign('idTienda')->references('id')->on('tiendas');
            $table->foreign('idUsuario')->references('id')->on('usuarios');
            $table->foreign('idProveedor')->references('id')->on('proveedors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido_proveedors');
    }
}
