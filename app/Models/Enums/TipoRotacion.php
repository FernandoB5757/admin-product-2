<?php

namespace App\Models\Enums;

use App\Traits\Enums\CanRestores;
use App\Traits\Enums\Collectable;
use App\Traits\Enums\WithConditionals;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

enum TipoRotacion: int implements HasLabel, HasColor
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

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Surtido => 'Surtido de los articulos',
            self::Venta => 'Venta de los articulos',
            self::Ajuste  => "Ajuste directo",
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Surtido => 'primary',
            self::Venta => 'success',
            self::Ajuste  => "warning",
        };
    }
}
