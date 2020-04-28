<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitaProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visita_proveedors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idTienda')->nullable(false);
            $table->foreignId('idUsuario')->nullable(false);
            $table->foreignId('idProveedor')->nullable(false);
            $table->foreignId('idPedido')->nullable(false);
            $table->foreignId('idEntrada')->nullable(false);
            $table->float('importe')->nullable(false);
            $table->boolean('pagado')->nullable(false);

            $table->timestamps();

            $table->foreign('idTienda')->references('id')->on('tiendas');
            $table->foreign('idUsuario')->references('id')->on('usuarios');
            $table->foreign('idPedido')->references('id')->on('pedido_proveedors');
            $table->foreign('idProveedor')->references('id')->on('proveedors');
            $table->foreign('idEntrada')->references('id')->on('entradas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visita_proveedors');
    }
}
