<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Departamento;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamento::create(['nombre' => 'Departamento 1']);
        Departamento::create(['nombre' => 'Departamento 2']);
        Departamento::create(['nombre' => 'Departamento 3']);
    }
}
