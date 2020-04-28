<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idTipoGasto');
            $table->foreignId('idUsuario');
            $table->foreignId('idTienda');
            $table->float('importe')->nullable(false);
            $table->dateTime('fecha')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'));
            $table->longText('descripcion')->nullable(false);
            $table->timestamps();

            $table->foreign('idTipoGasto')->references('id')->on('tipo_gastos');
            $table->foreign('idUsuario')->references('id')->on('usuarios');
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
        Schema::dropIfExists('gastos');
    }
}
