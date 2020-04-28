<?php

namespace App\Business;

use App\Models\Tienda as ModelsTienda;

class Tienda
{
    public static function add($data)
    {
        return ModelsTienda::create($data);
    }

    /**
     *
     * Get ModelsTienda collection searching by column and value
     *
     * @param string $column
     * @param mixed $value
     *
     * @return Illuminate\Database\Eloquent\Collection
     *
     */

    public static function getColumnValue($column, $value){
        return ModelsTienda::where($column,$value)->get();
    }

    public static function getArray( $array)
    {
        return ;
    }
}
