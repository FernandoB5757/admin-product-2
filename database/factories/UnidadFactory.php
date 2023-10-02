<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unidad>
 */
class UnidadFactory extends Factory
{
    protected array $unidadesMedida =
    [
        'litro',
        'mililitro',
        'galón',
        'onza',
        'libra',
        'kilogramo',
        'metro cúbico',
        'metro cuadrado',
        'centímetro cúbico',
        'pulgada cúbica',
        'unidad',
        'pieza',
        'par',
        'set',
        'kit',
    ];

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->randomElement($this->unidadesMedida),
            'clave' => $this->faker->unique()->currencyCode(),
        ];
    }
}
