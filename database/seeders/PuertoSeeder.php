<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Puerto;

class PuertoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Puerto::create(['nombre' => 'Puerto 1', 'direccion' => 'Calle 111 casi Calle 111']);
        Puerto::create(['nombre' => 'Puerto 2', 'direccion' => 'Calle 222 casi Calle 222']);
        Puerto::create(['nombre' => 'Puerto 3', 'direccion' => 'Calle 333 casi Calle 333']);
    }
}
