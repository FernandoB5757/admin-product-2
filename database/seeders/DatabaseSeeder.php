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
