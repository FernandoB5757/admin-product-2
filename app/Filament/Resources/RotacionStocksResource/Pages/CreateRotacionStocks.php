<?php

namespace App\Filament\Resources\RotacionStocksResource\Pages;

use App\Filament\Resources\RotacionStocksResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Hamcrest\Type\IsNumeric;
use Illuminate\Database\Eloquent\Model;

class CreateRotacionStocks extends CreateRecord
{
    protected static string $resource = RotacionStocksResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        dd($data);
        return static::getModel()::create($data);
    }
}
