<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

class CreateProductoEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_entradas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idEntrada');
            $table->foreignId('idProducto');
            $table->float('unidades')->nullable('false');
            $table->float('precioCompra')->nullable('false');
            $table->float('precioVenta')->nullable('false');
            $table->float('precioVentaAnterior')->nullable('false');


            $table->foreign('idEntrada')->references('id')->on('entradas');
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
        Schema::dropIfExists('producto_entradas');
    }
}
