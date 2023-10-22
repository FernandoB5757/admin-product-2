<?php

namespace App\Filament\Resources\RotacionStocksResource\Pages;

use App\Filament\Resources\RotacionStocksResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Hamcrest\Type\IsNumeric;

class CreateRotacionStocks extends CreateRecord
{
    protected static string $resource = RotacionStocksResource::class;
}
