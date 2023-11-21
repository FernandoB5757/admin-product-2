<?php

namespace App\Models\Enums;

use App\Traits\Enums\CanRestores;
use App\Traits\Enums\Collectable;
use App\Traits\Enums\WithConditionals;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum EstatusCaja: int implements HasLabel, HasColor
{
    use Collectable;
    use CanRestores;
    use WithConditionals;

    case Abierta = 1;
    case Cerrada = 2;
    case Cancelada = 3;


    public function getLabel(): ?string
    {
        return match ($this) {
            self::Abierta => 'Abierta',
            self::Cerrada => 'Cerrada',
            self::Cancelada => 'Cancelada',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Abierta => 'primary',
            self::Cerrada => 'success',
            self::Cancelada => 'danger',
        };
    }
}
