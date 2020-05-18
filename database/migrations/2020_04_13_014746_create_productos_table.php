<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',13);
            $table->foreignId('idTienda');
            $table->foreignId('idMarca');
            $table->string('producto')->nullable(false);
            $table->enum('unidadMedida',['ml','g','u'])->nullable(false);
            $table->enum('formaVenta',['pieza','granel'])->nullable(false);
            $table->float('tamano')->nullable(true);
            $table->float('disponible')->nullable(false)->default(0);
            $table->float('deseado')->nullable(false)->default(0);
            $table->float('precioVenta')->nullable(false)->default(0);
            $table->string('imagen')->default('producto_default.jpg');
            $table->boolean('activo')->nullable(false)->default(true);
            $table->timestamps();

            $table->foreign('idTienda')->references('id')->on('tiendas');
            $table->foreign('idMarca')->references('id')->on('marcas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
