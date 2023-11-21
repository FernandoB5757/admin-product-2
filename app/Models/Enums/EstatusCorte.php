<?php

namespace App\Models\Enums;

use App\Traits\Enums\CanRestores;
use App\Traits\Enums\Collectable;
use App\Traits\Enums\WithConditionals;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum EstatusCorte: int  implements HasLabel, HasColor
{
    use Collectable;
    use CanRestores;
    use WithConditionals;

    case Apertura = 1;
    case Cierre = 2;


    public function getLabel(): ?string
    {
        return match ($this) {
            self::Apertura => 'Apertura',
            self::Cierre => 'Cierre',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Apertura => 'primary',
            self::Cierre => 'success',
        };
    }
}
