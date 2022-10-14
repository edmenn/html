<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    /**
     * Para obtener el vinculo con la tabla users
     */
    public function users(){
        return $this->hasMany('App\Models\User', 'departamento_id');
    }

    /**
     * Para obtener el vinculo con la tabla presupuestos
     */
    public function presupuestos(){
        return $this->hasMany('App\Models\Presupuesto', 'departamento_id');
    }
}
