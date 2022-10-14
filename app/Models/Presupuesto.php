<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    /**
     * Para obtener el vinculo con la tabla localidades
     */
    public function localidad(){
        return $this->belongsTo('App\Models\Localidad', 'localidad_id');
    }

    /**
     * Para obtener el vinculo con la tabla departamentos
     */
    public function departamento(){
        return $this->belongsTo('App\Models\Departamento', 'departamento_id');
    }

    /**
     * Para obtener el vinculo con la tabla users
     */
    public function responsable(){
        return $this->belongsTo('App\Models\User', 'responsable_id');
    }

    /**
     * Para obtener el vinculo con la tabla estados
     */
    public function estado(){
        return $this->belongsTo('App\Models\Estado', 'estado_id');
    }

    /**
     * Para obtener el vinculo con la tabla proyectos
     */
    public function proyectos(){
        return $this->hasMany('App\Models\Proyecto', 'presupuesto_id');
    }
}
