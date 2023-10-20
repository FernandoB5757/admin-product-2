<?php

namespace App\Filament\Resources\AlmacenArticuloResource\Pages;

use App\Filament\Resources\AlmacenArticuloResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageAlmacenArticulos extends ManageRecords
{
    protected static string $resource = AlmacenArticuloResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data, string $model): Model {
                    $articuloAlmacen = $model::where('articulo_id', $data['articulo_id'])
                        ->where('almacen_id', $data['almacen_id'])->first();
                    if ($articuloAlmacen) {
                        $articuloAlmacen->stock = $data['stock'];
                        $articuloAlmacen->save();
                        return $articuloAlmacen;
                    }
                    return $model::create($data);
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Stock actualizado')
                        ->body('Se ah agregado al almacen el stock con exito.'),
                ),
        ];
    }
}
