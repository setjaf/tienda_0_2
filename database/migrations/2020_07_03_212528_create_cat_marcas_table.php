<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatMarcasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_marcas', function (Blueprint $table) {
            $table->id();
            $table->string('marca')->nullable(false);
            $table->longText('descripcion');
            $table->string('imagen')->default('marca_default.jpg');
            $table->boolean('activo')->nullable(false)->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_marcas');
    }
}
