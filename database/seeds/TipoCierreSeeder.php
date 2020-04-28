<?php

use App\Models\TipoCierre;
use Illuminate\Database\Seeder;

class TipoCierreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCierre::create([
            'cierre' => 'empleado',
            'descripcion' => 'El cierre se realizó cuando un empleado desea cerrar su sesión.',
        ]);

        TipoCierre::create([
            'cierre' => 'diario',
            'descripcion' => 'El cierre se realizó cuando el administrador desea saber como terminó el día.',
        ]);

        TipoCierre::create([
            'cierre' => 'semanal',
            'descripcion' => 'El cierre se realizó cuando el administrador desea saber como terminó la semana.',
        ]);
    }
}
