<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoPedido extends Model
{
    protected $fillable = [
        'idPedido', 'idProducto', 'cantidad'
    ];
}
