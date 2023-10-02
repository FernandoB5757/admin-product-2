<?php

namespace App\Models\Enums;

use App\Traits\Enums\CanRestores;
use App\Traits\Enums\Collectable;
use App\Traits\Enums\WithConditionals;

enum EstatusUnidad: int
{
    use Collectable;
    use CanRestores;
    use WithConditionals;

    case Activa = 1;
    case Inactiva = 0;
}
