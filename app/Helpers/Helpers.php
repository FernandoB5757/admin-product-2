<?php

namespace App\Helpers;

class Helpers
{
    public static function calcularIVA(float $subtotal, int  $porcentajeIVA = 16): float
    {
        return $subtotal * ($porcentajeIVA / 100);
    }
}
