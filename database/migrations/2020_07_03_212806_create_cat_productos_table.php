<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',13)->unique();
            $table->foreignId('idMarca');
            $table->string('producto')->nullable(false);
            $table->enum('unidadMedida',['ml','g','u'])->nullable(false);
            $table->enum('formaVenta',['pieza','granel'])->nullable(false);
            $table->float('tamano')->nullable(true);
            $table->string('imagen')->default('producto_default.jpg');
            $table->boolean('activo')->nullable(false)->default(true);
            $table->timestamps();

            $table->foreign('idMarca')->references('id')->on('cat_marcas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_productos');
    }
}
