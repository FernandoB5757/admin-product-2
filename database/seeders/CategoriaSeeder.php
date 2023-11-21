<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\SubCategoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoria_id = Categoria::create([
            'nombre' => 'Productos Limpieza'
        ])->id;

        DB::table('sub_categorias')->insert([
            [
                'categoria_id' => $categoria_id,
                'nombre' => 'Detergentes de ropa'
            ],
            [
                'categoria_id' => $categoria_id,
                'nombre' => 'Suavizante de telas'
            ],
            [
                'categoria_id' => $categoria_id,
                'nombre' => 'Quitamanchas y percudido'
            ],
            [
                'categoria_id' => $categoria_id,
                'nombre' => 'Sarricidas'
            ],
        ]);

        if (App::isLocal()) {
            $categoria_id = Categoria::factory()->create()->id;

            SubCategoria::factory()->count(3)->create([
                'categoria_id' => $categoria_id
            ]);

            $categoria_id = Categoria::factory()->create()->id;

            SubCategoria::factory()->count(3)->create([
                'categoria_id' => $categoria_id
            ]);
        }
    }
}
