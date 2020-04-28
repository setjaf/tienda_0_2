<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_proveedors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idProducto');
            $table->foreignId('idProveedor');
            $table->float('precio')->default(0);

            $table->timestamps();
            $table->foreign('idProducto')->references('id')->on('productos');
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
        Schema::dropIfExists('producto_proveedors');
    }
}
