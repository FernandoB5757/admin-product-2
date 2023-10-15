<?php

namespace App\Filament\Resources\UnidadResource\Pages;

use App\Filament\Resources\UnidadResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUnidads extends ManageRecords
{
    protected static string $resource = UnidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
