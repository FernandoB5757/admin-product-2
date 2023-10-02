<?php

namespace Database\Factories;

use App\Models\Articulo;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'cantidad_minima' => $this->faker->numberBetween(1, 30),
            'costo_unitario' => $this->faker->randomFloat(1, 10, 90),
            'costo' => $this->faker->randomFloat(1, 15, 100),
        ];
    }

    /**
     * Le asigna y crea articulos al producto.
     */
    public function withArticulos(int|callable $count = 1): static
    {
        return $this->afterCreating(function (Producto $producto) use ($count): void {
            $times = is_callable($count) ? $count() : $count;

            Articulo::factory()
                ->count($times)
                ->create([
                    ' producto_id' => $producto->id,
                ]);
        });
    }
}
