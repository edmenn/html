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

    /**
     * Para obtener el vinculo con la tabla cancelacion_monto
     */
    public function cancelacionMontos(){
        return $this->hasMany('App\Models\CancelacionMonto', 'subproyecto_id');
    }

    /**
     * Para obtener el vinculo con la tabla comentarios
     */
    public function comentarios(){
        return $this->hasMany('App\Models\Comentario', 'subproyecto_id');
    }

    /**
     * Para obtener el vinculo con la tabla documentos
     */
    public function documentos(){
        return $this->hasMany('App\Models\Documento', 'subproyecto_id');
    }

    /**
     * Para obtener el vinculo con la tabla licitaciones
     */
    public function licitaciones(){
        return $this->hasMany('App\Models\Licitacion', 'subproyecto_id');
    }
}
