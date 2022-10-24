<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjudicacion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'adjudicaciones';

    /**
     * Para obtener el vinculo con la tabla licitaciones
     */
    public function licitacion(){
        return $this->belongsTo('App\Models\licitacion', 'licitacion_id');
    }
}
