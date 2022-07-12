<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProyecto extends Model
{
    use HasFactory;

    /**
     * Para obtener el vinculo con la tabla proyectos
     */
    public function proyecto(){
        return $this->belongsTo('App\Models\Proyecto', 'proyecto_id');
    }
}
