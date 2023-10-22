<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RotacionStocksResource\Pages;
use App\Filament\Resources\RotacionStocksResource\RelationManagers;
use App\Helpers\Helpers;
use App\Models\Articulo;
use App\Models\RotacionStocks;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component as Livewire;

class RotacionStocksResource extends Resource
{
    protected static ?string $model = RotacionStocks::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Ajuste Existencias';

    protected static ?string $navigationGroup = 'Almacen';

    protected static ?string $modelLabel = 'ajuste';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('descripcion')
                    ->required()
                    ->translateLabel()
                    ->columnSpanFull()
                    ->live(),
                Repeater::make('rotaciones')
                    ->relationship()
                    ->schema([
                        Grid::make(12)
                            ->schema([
                                Select::make('articulo_id')
                                    ->label('Articulo')
                                    ->options(options: function (
                                        Get $get,
                                        string|int|null $state
                                    ) {
                                        $ids = Helpers::getNoRepetId($get('../../rotaciones'), $state ?? 0);
                                        return Articulo::query()->whereNotIn('id', $ids)
                                            ->get()->pluck('nombre', 'id')->toArray();
                                    })
                                    ->getSearchResultsUsing(
                                        function (string $search, Get $get): array {
                                            $ids = Helpers::getNoRepetId($get('../../rotaciones'), $state ?? 0);
                                            return Articulo::where('nombre', 'like', "%{$search}%")
                                                ->orWhere('clave', $search)
                                                ->whereNotIn('id', $ids)
                                                ->limit(10)
                                                ->pluck('nombre', 'id')
                                                ->toArray();
                                        }
                                    )
                                    ->afterStateUpdated(
                                        function (?string $state, Get $get, Set $set): array {
                                            // $stock =
                                        }
                                    )
                                    ->searchable()
                                    ->columnSpanFull(),
                                TextInput::make('stock_antes')
                                    ->columnSpan([
                                        'sm' => 12,
                                        'md' => 6
                                    ])
                                    ->required()
                                    ->disabled()
                                    ->readOnly()
                                    ->numeric()
                                    ->prefixIcon('heroicon-o-inbox-stack'),
                                TextInput::make('stock_despues')
                                    ->columnSpan([
                                        'sm' => 12,
                                        'md' => 6
                                    ])
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->step(0.5)
                                    ->prefixIcon('heroicon-o-inbox-stack'),
                            ])

                    ])
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        /*
          'tipo',
        'user_id',
        'almacen_id',
        // 'venta_id',
        'descripcion' */
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('almacen.nombre')
                    ->label('Almacén')
                    ->sortable(),
                TextColumn::make('tipo')
                    ->badge()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable(),
                TextColumn::make('almacen.nombre')
                    ->label('Almacén'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    // Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRotacionStocks::route('/'),
            'create' => Pages\CreateRotacionStocks::route('/create'),
            // 'edit' => Pages\EditRotacionStocks::route('/{record}/edit'),
            // 'view' => Pages\ViewRotacionStocks::route('/{record}/edit'),
        ];
    }
}
