<?php

namespace App\Filament\Resources\CorteResource\Pages;

use App\Actions\Corte\CreateNewCorte;
use App\Filament\Resources\CorteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCorte extends CreateRecord
{
    protected static string $resource = CorteResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $creator = app(CreateNewCorte::class);
        return $creator->create($data);
    }
}
