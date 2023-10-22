<?php

namespace App\Filament\Resources;

use App\Actions\Almacen\UpdateStock;
use App\Filament\Resources\AlmacenArticuloResource\Pages;
use App\Filament\Resources\AlmacenArticuloResource\RelationManagers;
use App\Models\AlmacenArticulo;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AlmacenArticuloResource extends Resource
{
    protected static ?string $model = AlmacenArticulo::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'Existencias';

    protected static ?string $navigationGroup = 'Almacen';

    protected static ?string $modelLabel = 'existencia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('articulo_id',)
                    ->relationship(name: 'articulo', titleAttribute: 'nombre')
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('almacen_id',)
                    ->relationship(name: 'almacen', titleAttribute: 'nombre')
                    ->preload()
                    ->required(),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->step(0.5)
                    ->prefixIcon('heroicon-o-inbox-stack')
                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Cantidad en almacen. Ejemplo: 5 botes de 1LTR de suavitel.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('articulo.nombre')
                    ->label('Articulo')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('articulo.clave')
                    ->label('Clave de articulo')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('almacen.nombre')
                    ->label('Almacén'),
                TextColumn::make('stock')
                    ->label('Cantidad en stock')
                    ->numeric(
                        decimalPlaces: 2,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )
                    ->icon('heroicon-o-inbox-stack')
                    ->iconPosition(IconPosition::Before),
            ])
            ->filters([
                SelectFilter::make('articulo')
                    ->relationship('articulo', 'nombre')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('almacen')
                    ->relationship('almacen', 'nombre')
                    ->preload()
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Stock actualizado')
                                ->body('Se ah agregado al almacen el stock con exito.'),
                        )
                        ->using(function (Model $record, array $data, string $model): Model {
                            return UpdateStock::updateOrCreate($data);
                        }),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAlmacenArticulos::route('/'),
        ];
    }
}
