<?php

namespace App\Traits\Enums;

use ReflectionEnumBackedCase;
use ReflectionException;
use UnitEnum;

trait CanRestores
{
    /**
     * Obtiene el Enum dependiendo del nombre. Devuelve nulo si no existe ese case.
     */
    public static function fromName(string $value): ?UnitEnum
    {
        try {
            $reflection = new ReflectionEnumBackedCase(static::class, $value);

            return $reflection->getValue();
        } catch (ReflectionException $e) {
            return null;
        }
    }
}
