<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipo_documento';

    /**
     * Para obtener el vinculo con la tabla documentos
     */
    public function documentos(){
        return $this->hasMany('App\Models\Documento', 'tipo_documento_id');
    }
}
