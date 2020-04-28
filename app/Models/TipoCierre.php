<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCierre extends Model
{
    public function cierres()
    {
        return $this->hasMany('App\Models\Cierre','idTipoCierre');
    }

    protected $fillable = [
        'cierre', 'descripcion'
    ];
}
