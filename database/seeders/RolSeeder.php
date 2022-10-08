<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::create(['nombre' => 'administracion', 'descripcion' => 'Administración']);
        Rol::create(['nombre' => 'jefe_departamental', 'descripcion' => 'Jefe Departamental']);
        Rol::create(['nombre' => 'funcionario', 'descripcion' => 'Funcionario']);
        Rol::create(['nombre' => 'orden_compra', 'descripcion' => 'Orden de Compra']);
    }
}
