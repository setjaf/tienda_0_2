<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCierresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cierres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idTipoCierre');
            $table->foreignId('idTienda');
            $table->foreignId('idUsuario');
            $table->dateTime('fecha')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'));
            $table->float('billetes')->nullable(false);
            $table->float('monedas')->nullable(false);
            $table->float('total')->nullable(false);
            $table->longText('comentarios')->nullable(true);
            $table->timestamps();

            $table->foreign('idTipoCierre')->references('id')->on('tipo_cierres');
            $table->foreign('idTienda')->references('id')->on('tiendas');
            $table->foreign('idUsuario')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cierres');
    }
}
