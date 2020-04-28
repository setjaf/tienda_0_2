<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'idEmpleado','entrada','salida'
    ];

    protected $casts = [
        'entrada'=>'datetime',
        'salida'=>'datetime'
    ];
}
