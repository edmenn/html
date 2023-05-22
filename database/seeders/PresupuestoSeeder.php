<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presupuesto;
use Faker;

class PresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('es_AR');
        $faker->seed(1234);

        Presupuesto::create([
            'anho_fiscal' => 2021,
            'codigo' => 1,
            'localidad_id' => 1,
            'nombre' => 'Construcción Depósito 1',
            'descripcion' => 'Nuevo Depósito para almacenamiento de granos',
            'departamento_id' => 1,
            'responsable_id' => 2,
            'costo' => 500000000,
            'estado_id' => 2,
            'tipo' => 'CAPEX',
        ]);
        Presupuesto::create([
            'anho_fiscal' => 2022,
            'codigo' => 1,
            'localidad_id' => 2,
            'nombre' => 'Compra de Computadoras',
            'descripcion' => 'Computadoras para nuevos funcionarios en Paredon',
            'departamento_id' => 1,
            'responsable_id' => 3,
            'costo' => 55000000,
            'estado_id' => 2,
            'tipo' => 'OPEX',
        ]);
        Presupuesto::create([
            'anho_fiscal' => 2022,
            'codigo' => 2,
            'localidad_id' => 1,
            'nombre' => 'Compra de Vehiculo',
            'descripcion' => 'Compra de una nueva camioneta para el Gerente de Planta',
            'departamento_id' => 2,
            'responsable_id' => 4,
            'costo' => 280000000,
            'estado_id' => 1,
            'tipo' => 'CAPEX',
        ]);

        $tipo = array('CAPEX', 'OPEX');
        for ($i=1; $i <= 150; $i++) { 
            Presupuesto::create([
                'anho_fiscal' => $faker->numberBetween(2018, 2023),
                'codigo' => $i,
                'localidad_id' => $faker->numberBetween(1, 7),
                'nombre' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'descripcion' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'departamento_id' => $faker->numberBetween(1, 3),
                'responsable_id' => $faker->numberBetween(1, 36),
                'costo' => $faker->numberBetween(200000000, 1000000000),
                'estado_id' => $faker->numberBetween(1, 3),
                'tipo' => $tipo[$faker->numberBetween(0, 1)],
            ]);
        }
    }
}
