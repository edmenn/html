<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelacionMonto extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cancelacion_monto';

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
}
