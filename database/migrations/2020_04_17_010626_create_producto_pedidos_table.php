<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idProducto');
            $table->foreignId('idPedido');
            $table->float('cantidad');
            $table->timestamps();

            $table->foreign('idPedido')->references('id')->on('pedido_proveedors');
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
        Schema::dropIfExists('producto_pedidos');
    }
}
