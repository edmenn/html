<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    /**
     * Para obtener el vinculo con la tabla users
     */
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Para obtener el vinculo con la tabla estados
     */
    public function estado(){
        return $this->belongsTo('App\Models\Estado', 'estado_id');
    }

    /**
     * Para obtener el vinculo con la tabla presupuestos
     */
    public function presupuesto(){
        return $this->belongsTo('App\Models\Presupuesto', 'presupuesto_id');
    }

    /**
     * Para obtener el vinculo con la tabla subproyectos
     */
    public function subproyectos(){
        return $this->hasMany('App\Models\Subproyecto', 'proyecto_id');
    }

    /**
     * Para obtener el vinculo con la tabla cancelacion_monto
     */
    public function cancelacionMontos(){
        return $this->hasMany('App\Models\CancelacionMonto', 'proyecto_id');
    }
}
