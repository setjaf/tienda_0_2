<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUsuario')->nullable(false);
            $table->foreignId('idTienda')->nullable(false);
            $table->datetime('inicio')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'));
            $table->enum('formaPago',['diario','semanal','quincenal']);
            $table->float('sueldo')->default(0.0);
            $table->timestamps();

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
        Schema::dropIfExists('empleados');
    }
}
