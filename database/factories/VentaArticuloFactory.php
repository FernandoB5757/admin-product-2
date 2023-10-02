<?php

namespace Database\Factories;

use App\Models\Articulo;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VentaArticulo>
 */
class VentaArticuloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $articulo = optional(Articulo::inRandomOrder()->first());
        $precio = $articulo->precio ?? $this->faker->randomFloat(2, 1, 250);

        return [
            'venta_id' =>  optional(Venta::inRandomOrder()->first()),
            'articulo_id' => $articulo->id,
            'precio' => $articulo->precio ?? $this->faker->randomFloat(2, 1, 250),
            'cantidad' => $this->faker->numberBetween(1, 5)
        ];
    }

    public function conEmbace()
    {
        return $this->state(function (array $attributes) {
            return [
                'con_embace' => true,
            ];
        });
    }
}
