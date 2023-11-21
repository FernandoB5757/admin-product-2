<?php

namespace Database\Seeders;

use App\Models\Articulo;
use App\Models\Producto;
use App\Models\SubCategoria;
use App\Models\Unidad;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sub_categoriaId = SubCategoria::find(1)->id;
        $unidadId = Unidad::find(1)->id;

        $productoId = Producto::create([
            'nombre' => 'SH. MAXI COLOR AZUL No. 1 ECO',
            'cantidad_minima' => '10',
            'sub_categoria_id' => $sub_categoriaId,
            'unidad_id' => $unidadId,
            'costo_unitario' => 11.5,
            'costo' => 10.5,
        ])->id;

        $productoId = Producto::create([
            'nombre' => 'SH. MAXI COLOR BLANCO',
            'cantidad_minima' => '10',
            'sub_categoria_id' => $sub_categoriaId,
            'unidad_id' => $unidadId,
            'costo_unitario' => 11.9,
            'costo' => 10.9,
        ])->id;

        $productoId = Producto::create([
            'nombre' => 'SH. MAXI COLOR NEGRO ECO',
            'cantidad_minima' => '10',
            'sub_categoria_id' => $sub_categoriaId,
            'unidad_id' => $unidadId,
            'costo_unitario' => 11.9,
            'costo' => 10.9,
        ])->id;


        $productoId = Producto::create([
            'nombre' => 'SH. MAXI COLOR MEZCLILLA',
            'cantidad_minima' => '10',
            'sub_categoria_id' => $sub_categoriaId,
            'unidad_id' => $unidadId,
            'costo_unitario' => 11.5,
            'costo' => 11.5,
        ])->id;
    }
}
