<?php

namespace App\Models\Enums;

use App\Traits\Enums\CanRestores;
use App\Traits\Enums\Collectable;
use App\Traits\Enums\WithConditionals;

enum EstatusCorte: int
{
    use Collectable;
    use CanRestores;
    use WithConditionals;

    case Apertura = 1;
    case Cierre = 2;
}
