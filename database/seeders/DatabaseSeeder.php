<?php

namespace Database\Seeders;

use App\Models\ModelExample;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::isLocal()) {
            $this->call([
                CategoriaSeeder::class,
                AlmacenSeeder::class,
                CajaSeeder::class,
                UnidadSeeder::class,
                ProductoSeederTest::class,
                RolesSeeder::class,
                LocalUserSeeder::class,
                VentaSeeder::class,
            ]);
        }

        if (App::isProduction()) {
            $this->call([
                CategoriaSeeder::class,
                AlmacenSeeder::class,
                CajaSeeder::class,
                UnidadSeeder::class,
                ProductoSeeder::class,
                RolesSeeder::class,
                LocalUserSeeder::class,
                VentaSeeder::class,
            ]);
        }
    }
}
