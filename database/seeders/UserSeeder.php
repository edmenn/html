<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administración',
            'email' => 'administracion@gestapp.com',
            'departamento_id' => 1,
            'password' => Hash::make('admin.gestapp2022'),
        ]);
    }
}
