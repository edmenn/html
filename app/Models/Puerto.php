<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puerto extends Model
{
    use HasFactory;

    /**
     * Para obtener el vinculo con la tabla proyectos
     */
    public function proyectos(){
        return $this->hasMany('App\Models\Proyecto', 'puerto_id');
    }
}
