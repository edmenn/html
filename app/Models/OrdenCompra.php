<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ordenes_compra';

    /**
     * Para obtener el vinculo con la tabla proveedores
     */
    public function proveedor(){
        return $this->belongsTo('App\Models\Proveedor', 'proveedor_id');
    }

    /**
     * Para obtener el vinculo con la tabla documentos
     */
    public function documentos(){
        return $this->hasMany('App\Models\Documento', 'licitacion_id');
    }
}
