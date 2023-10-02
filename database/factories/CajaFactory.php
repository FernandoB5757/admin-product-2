<?php

namespace Database\Factories;

use App\Models\Enums\EstatusCaja;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Caja>
 */
class CajaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => "Caja {$this->faker->unique()->randomDigit()}",
            'estatus' => EstatusCaja::Cerrada->value
        ];
    }
}
