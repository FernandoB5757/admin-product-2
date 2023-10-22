<?php

namespace App\Filament\Resources\RotacionStocksResource\Pages;

use App\Filament\Resources\RotacionStocksResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRotacionStocks extends ListRecords
{
    protected static string $resource = RotacionStocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
