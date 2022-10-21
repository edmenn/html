<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proveedores';

    /**
     * Para obtener el vinculo con la tabla licitaciones
     */
    public function licitaciones(){
        return $this->hasMany('App\Models\Licitacion', 'proveedor_id');
    }
}
