<?php

namespace App\Filament\Resources\RotacionStocksResource\Pages;

use App\Filament\Resources\RotacionStocksResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRotacionStocks extends EditRecord
{
    protected static string $resource = RotacionStocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
