<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    private static array $categorias = [
        'Aparatos',
        'Celulosa',
        'Protección',
        'Químicos',
        'Útiles de Limpieza',
        'Varios',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->randomElement(self::$categorias),
        ];
    }
}
