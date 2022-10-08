<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    /**
     * Para obtener el vinculo con la tabla presupuestos
     */
    public function presupuestos(){
        return $this->hasMany('App\Models\Presupuesto', 'estado_id');
    }

    /**
     * Para obtener el vinculo con la tabla proyectos
     */
    public function proyectos(){
        return $this->hasMany('App\Models\Proyecto', 'estado_id');
    }
}
