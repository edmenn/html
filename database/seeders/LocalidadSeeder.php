<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Localidad;

class LocalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Localidad::create(['nombre' => 'Localidad 1', 'direccion' => 'Calle 111 casi Calle 111']);
        Localidad::create(['nombre' => 'Localidad 2', 'direccion' => 'Calle 222 casi Calle 222']);
        Localidad::create(['nombre' => 'Localidad 3', 'direccion' => 'Calle 333 casi Calle 333']);
    }
}
