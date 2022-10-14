<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 5; $i++) { 
            Proveedor::create([
                'nombre_fantasia' => 'Proveedor '.$i, 
                'razon_social' => 'Razon Social '.$i,
                'ruc' => $i.$i.$i.$i.$i.$i.$i,
                'telefono' => '098122211'.$i,
                'direccion' => 'CALLE '.$i.' casi CALLE '.($i+1),
            ]);
        }
    }
}
