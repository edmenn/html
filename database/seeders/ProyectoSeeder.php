<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proyecto;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PRESUPUESTO 1
        Proyecto::create([
            'nombre' => 'Preparación suelo',
            'descripcion' => 'Preparación suelo para Construcción del Depósito 1',
            'anho_fiscal' => 2021,
            'codigo' => 1,
            'presupuesto_id' => 1,
            'user_id' => 11,
            'costo' => 80000000,
            'estado_id' => 1,
            'contratado' => 40000000,
        ]);
        Proyecto::create([
            'nombre' => 'Construcción estructura',
            'descripcion' => 'Construcción estructura para Construcción del Depósito 1',
            'anho_fiscal' => 2021,
            'codigo' => 2,
            'presupuesto_id' => 1,
            'user_id' => 12,
            'costo' => 120000000,
            'estado_id' => 1,
            'contratado' => 80000000,
        ]);
        Proyecto::create([
            'nombre' => 'Instalación Eléctrica',
            'descripcion' => 'Instalación Eléctrica para Construcción del Depósito 1',
            'anho_fiscal' => 2021,
            'codigo' => 3,
            'presupuesto_id' => 1,
            'user_id' => 12,
            'costo' => 75000000,
            'estado_id' => 1,
            'contratado' => 0,
        ]);

        // PRESUPUESTO 2
        Proyecto::create([
            'nombre' => '10 Computadoras Dell',
            'descripcion' => 'Compra de Computadoras',
            'anho_fiscal' => 2022,
            'codigo' => 1,
            'presupuesto_id' => 2,
            'user_id' => 13,
            'costo' => 45000000,
            'estado_id' => 2,
            'contratado' => 45000000,
        ]);

        // PRESUPUESTO 3
        Proyecto::create([
            'nombre' => 'Compra Volkswagen Amarok 2019',
            'descripcion' => 'Compra de Vehiculo',
            'anho_fiscal' => 2022,
            'codigo' => 1,
            'presupuesto_id' => 3,
            'user_id' => 14,
            'costo' => 210000000,
            'estado_id' => 2,
            'contratado' => 210000000,
        ]);
    }
}
