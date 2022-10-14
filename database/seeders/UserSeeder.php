<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker;

class UserSeeder extends Seeder
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
        
        User::create([
            'rol_id' => 1,
            'nombre' => 'Administración',
            'apellido' => '',
            'cedula' => '123456',
            'email' => 'administracion@gestapp.com',
            'departamento_id' => 1,
            'password' => Hash::make('admin.gestapp2022'),
        ]);

        /****** JEFES ******/
        for ($i=1; $i <= 10; $i++) { 
            User::create([
                'rol_id' => 2,
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'cedula' => $faker->numberBetween(1000000, 9000000),
                'email' => str_replace("@", $i."@", $faker->email),
                'departamento_id' => $faker->numberBetween(1, 3),
                'password' => Hash::make('123'),
            ]);
        }

        /****** FUNCIONARIOS ******/
        for ($i=11; $i <= 30; $i++) { 
            User::create([
                'rol_id' => 3,
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'cedula' => $faker->numberBetween(1000000, 9000000),
                'email' => str_replace("@", $i."@", $faker->email),
                'departamento_id' => $faker->numberBetween(1, 3),
                'password' => Hash::make('123'),
            ]);
        }

        /****** ROL ORDEN DE COMPRA ******/
        for ($i=31; $i <= 35; $i++) { 
            User::create([
                'rol_id' => 4,
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'cedula' => $faker->numberBetween(1000000, 9000000),
                'email' => str_replace("@", $i."@", $faker->email),
                'departamento_id' => $faker->numberBetween(1, 3),
                'password' => Hash::make('123'),
            ]);
        }
    }
}
