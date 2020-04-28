<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoCategoria extends Model
{
    protected $fillable = [
        'idCategoria','idProducto'
    ];
}
