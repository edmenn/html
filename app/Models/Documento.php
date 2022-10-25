<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    /**
     * Para obtener el vinculo con la tabla proyectos
     */
    public function proyecto(){
        return $this->belongsTo('App\Models\Proyecto', 'proyecto_id');
    }

    /**
     * Para obtener el vinculo con la tabla subproyectos
     */
    public function subproyecto(){
        return $this->belongsTo('App\Models\Subproyecto', 'subproyecto_id');
    }

    /**
     * Para obtener el vinculo con la tabla licitacions
     */
    public function licitacion(){
        return $this->belongsTo('App\Models\Licitacion', 'licitacion_id');
    }

    /**
     * Para obtener el vinculo con la tabla tipo_documento
     */
    public function tipoDocumento(){
        return $this->belongsTo('App\Models\TipoDocumento', 'tipo_documento_id');
    }

    /**
     * Para obtener el vinculo con la tabla ordenes_compras
     */
    public function ordenCompra(){
        return $this->belongsTo('App\Models\OrdenCompra', 'orden_compra_id');
    }
}
