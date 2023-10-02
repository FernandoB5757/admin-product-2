<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategorias>
 */
class SubCategoriaFactory extends Factory
{
    private static array $sub_categorias = [
        'Ambientadores',
        'Droguería',
        'Ecológicos',
        'Especiales',
        'Higiene personal',
        'Limpiadores generales',
        'Suelos',
        'Talleres y lavaderos',
        'Tratamientos de piscinas',
        'Lavanderia',
        'Carros limpieza',
        'Dispensadores',
        'Maquinaria',
        'Bayetas',
        'Bolsas de basura',
        'Cepillos',
        'Cubos',
        'Envase',
        'Estropajos',
        'FErretería',
        'Fregonas',
        'Opasmopas',
        'Palos',
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->randomElement(self::$sub_categorias),
        ];
    }
}
