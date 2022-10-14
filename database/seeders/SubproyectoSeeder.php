<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subproyecto;

class SubproyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PROYECTO 1
        Subproyecto::create([
            'proyecto_id' => 1,
            'nombre' => 'Remover suelo con tractor',
            'descripcion' => 'Remover suelo con tractor, parte 1 de preparación de suelo',
            'codigo' => 1,
            'costo' => 15000000,
            'estado_id' => 1,
            'contratado' => 15000000,
        ]);
        Subproyecto::create([
            'proyecto_id' => 1,
            'nombre' => 'Rellenar fosa con piedras y cemento',
            'descripcion' => 'Parte 2 de preparación de suelo',
            'codigo' => 1,
            'costo' => 5000000,
            'estado_id' => 2,
            'contratado' => 4500000,
        ]);
    }
}
