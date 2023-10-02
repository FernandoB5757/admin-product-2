<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Articulo>
 */
class ArticuloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usa_embace = $this->faker->boolean();

        return [
            'producto_id' => optional(Producto::inRandomOrder()->first())->id,
            'nombre' => $this->faker->unique()->word(),
            'clave' => $this->faker->unique()->numerify('articulo-####'),
            'clave_alterna' => $this->faker->unique()->numerify('at-####'),
            'valor_equivalente' =>  $this->faker->numberBetween(1, 10),
            'usa_embace' => $usa_embace,
            'insumo' => false,
            'precio' => $this->faker->randomFloat(2, 1, 70),
            'precio_embase' => $usa_embace === true ? $this->faker->randomFloat(2, 0.5, 10) : null
        ];
    }
}
