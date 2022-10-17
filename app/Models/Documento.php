<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    /**
     * Para obtener el vinculo con la tabla tipo_documento
     */
    public function tipoDocumento(){
        return $this->belongsTo('App\Models\TipoDocumento', 'tipo_documento_id');
    }
}
