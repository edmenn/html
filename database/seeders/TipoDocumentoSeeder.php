<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDocumento::create(['nombre' => 'Tipo Documento 1']);
        TipoDocumento::create(['nombre' => 'Tipo Documento 2']);
        TipoDocumento::create(['nombre' => 'Tipo Documento 3']);
    }
}
