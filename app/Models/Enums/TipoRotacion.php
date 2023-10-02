<?php

namespace App\Models\Enums;

use App\Traits\Enums\CanRestores;
use App\Traits\Enums\Collectable;
use App\Traits\Enums\WithConditionals;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

enum TipoRotacion: int
{
    use Collectable;
    use CanRestores;
    use WithConditionals;

    case Venta = 1;
    case Surtido = 2;
    case Ajuste = 3;
    // case Movimiento = 4;

    public function descripcion(): string
    {
        return match ($this) {
            self::Surtido => 'Surtido de los articulos.',
            self::Venta => 'Venta de los articulos.',
            self::Ajuste  => "Ajuste Directo.",
        };
    }
}
