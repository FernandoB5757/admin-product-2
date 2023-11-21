<?php

namespace App\Helpers;

use Illuminate\Support\Arr;

class Helpers
{
    public static function calcularIVA(float $subtotal, int  $porcentajeIVA = 16): float
    {
        return $subtotal * ($porcentajeIVA / 100);
    }

    public static function makePrecio(
        string|float|null $costo_unitario = null,
        string|float|null $valor_equivalente = null,
        string|float|null $porcentaje = null
    ): float {
        $costo_unitario = floatval($costo_unitario ?? 0);
        $valor_equivalente = floatval($valor_equivalente ?? 0);
        $porcentaje = floatval($porcentaje ?? 0) *  0.01;

        return  number_format(($costo_unitario * $porcentaje) + $costo_unitario * $valor_equivalente, 2);
    }


    public static function getNoRepetId(array $array, int $distincValue): array
    {
        $mappedIds =  Arr::map($array, function (array $item) {
            return $item['articulo_id'] ?? 0;
        });

        if (($key = array_search($distincValue, $mappedIds)) !== false) {
            unset($mappedIds[$key]);
        }

        return $mappedIds;
    }
}
