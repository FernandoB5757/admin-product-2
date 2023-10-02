<?php

namespace App\Traits\Enums;

use Illuminate\Support\Collection;

trait Collectable
{
    /**
     * Obtiene los values de una key dada.
     */
    public static function pluck(string|int|array $value, ?string $key = null): array
    {
        return static::collect()->pluck($value, $key)->toArray();
    }

    /**
     * Devuelve los casos en una colección.
     */
    public static function collect(): Collection
    {
        return new Collection(static::cases());
    }


    /**
     * Devuelve los casos en una colección peron en array.
     */
    public static function dataSource(): Collection
    {
        return  static::collect()->map(function ($case) {
            return ['value' => $case->value, 'name' => $case->name];
        });
    }
}
