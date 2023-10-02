<?php

namespace App\Models\Enums;

use App\Traits\Enums\CanRestores;
use App\Traits\Enums\Collectable;
use App\Traits\Enums\WithConditionals;

enum EstatusCaja: int
{
    use Collectable;
    use CanRestores;
    use WithConditionals;

    case Abierta = 1;
    case Cerrada = 2;
    case Cancelada = 3;
}
