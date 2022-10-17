<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LocalidadSeeder::class,
            DepartamentoSeeder::class,
            RolSeeder::class,
            UserSeeder::class,
            EstadoSeeder::class,
            ProveedorSeeder::class,
            PresupuestoSeeder::class,
            ProyectoSeeder::class,
            SubproyectoSeeder::class,
            TipoDocumentoSeeder::class,
        ]);
    }
}
