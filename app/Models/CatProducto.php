<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatProducto extends Model
{
    public function marca()
    {
        return $this->belongsTo('App\Models\CatMarca','idMarca');
    }
}
