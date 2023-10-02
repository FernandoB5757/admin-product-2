<?php

namespace Database\Factories;

use App\Helpers\Helpers;
use App\Models\Corte;
use App\Models\Venta;
use App\Models\VentaArticulo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 10, 320);
        $iva = Helpers::calcularIVA($subtotal);

        return [
            'corte_id' => optional(Corte::inRandomOrder()->first())->id,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $subtotal + $iva,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function conCorte()
    {
        return $this->state(function (array $attributes) {
            $corte = Corte::factory()->create();
            return [
                'caja_id' => $corte->caja_id,
                'corte_id' => $corte->id
            ];
        });
    }

    /**
     * Configure the model factory.
     */
    public function withArticulos(int|callable $count = 1): static
    {
        return $this->afterCreating(function (Venta $venta) use ($count): void {
            $times = is_callable($count) ? $count() : $count;

            VentaArticulo::factory()
                ->count($times)
                ->create(
                    ['venta_id' => $venta->id]
                );
        });
    }
}
