<?php

namespace Modules\Localidade\Database\Seeders;

use Illuminate\Database\Seeder;

class LocalidadeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            EstadoTableSeeder::class
        ]);
    }
}
