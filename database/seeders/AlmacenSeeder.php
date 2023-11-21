<?php

namespace Database\Seeders;

use App\Models\Almacen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $almacen = Almacen::create(
            [
                'nombre' => 'Almacén 1',
                'ubicacion' => 'Ubicación',
                'descripcion' => 'Estan todos los productos.',
            ]
        );
    }
}
