<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'localidades';

    /**
     * Para obtener el vinculo con la tabla proyectos
     */
    public function proyectos(){
        return $this->hasMany('App\Models\Proyecto', 'localidad_id');
    }
}
