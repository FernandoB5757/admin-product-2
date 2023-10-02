<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unidades')->insert([
            ['nombre' => 'litro', 'clave' => 'LTR'],
            ['nombre' => 'mililitro', 'clave' => 'MLT'],
            ['nombre' => 'galón', 'clave' => 'GLL'],
            ['nombre' => 'onza', 'clave' => 'ONZ'],
            ['nombre' => 'libra', 'clave' => 'LBR'],
            ['nombre' => 'kilogramo', 'clave' => 'KGM'],
            ['nombre' => 'metro cúbico', 'clave' => 'MTQ'],
            ['nombre' => 'metro cuadrado', 'clave' => 'MTK'],
            ['nombre' => 'centímetro cúbico', 'clave' => 'CMQ'],
            ['nombre' => 'pulgada cúbica', 'clave' => 'CI'],
            ['nombre' => 'unidad', 'clave' => 'H87'],
            ['nombre' => 'pieza', 'clave' => 'XBX'],
            ['nombre' => 'par', 'clave' => 'PR'],
            ['nombre' => 'set', 'clave' => 'SET'],
            ['nombre' => 'kit', 'clave' => 'KT'],
        ]);
    }
}
