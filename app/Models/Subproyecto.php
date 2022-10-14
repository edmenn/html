<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subproyecto extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subproyectos';

    /**
     * Para obtener el vinculo con la tabla proyectos
     */
    public function proyecto(){
        return $this->belongsTo('App\Models\Proyecto', 'proyecto_id');
    }

    /**
     * Para obtener el vinculo con la tabla estados
     */
    public function estado(){
        return $this->belongsTo('App\Models\Estado', 'estado_id');
    }
}
