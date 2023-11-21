<?php

namespace Database\Seeders;

use App\Models\Caja;
use App\Models\Enums\EstatusCaja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Caja::create(
            [
                'nombre' => 'Caja 1',
                'estatus' => EstatusCaja::Cerrada,
            ]
        );
    }
}
