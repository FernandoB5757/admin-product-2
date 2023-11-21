<?php

namespace App\Filament\Resources\CorteResource\Pages;

use App\Filament\Resources\CorteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCorte extends EditRecord
{
    protected static string $resource = CorteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
