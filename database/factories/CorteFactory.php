<?php

namespace Database\Factories;

use App\Models\Caja;
use App\Models\Enums\EstatusCorte;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Corte>
 */
class CorteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hoy = now();
        return [
            'caja_id' => optional(Caja::inRandomOrder()->first())->id,
            'dinero_apertura' => $this->faker->randomFloat(2, 10, 100),
            'dinero_cierre' => $this->faker->randomFloat(2, 10, 100),
            'fecha_apertura' => $hoy->format('Y-m-d 11:00:00'),
            'fecha_cierre' => $hoy->format('Y-m-d 17:00:00'),
            'estatus' => EstatusCorte::Cierre->value,
        ];
    }
}
