<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoGasto extends Model
{
    protected $fillable = [
        'idTienda', 'nombre', 'descripcion', 'color'
    ];
}
