<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RotacionStocksResource\Pages;
use App\Filament\Resources\RotacionStocksResource\RelationManagers;
use App\Helpers\Helpers;
use App\Models\AlmacenArticulo;
use App\Models\Articulo;
use App\Models\Enums\TipoRotacion;
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
                Select::make('user_id')
                    ->label('Creador')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->disabled()
                    ->columnSpan(1),
                Select::make('tipo')
                    ->options(TipoRotacion::class)
                    ->disabled()
                    ->columnSpan(1),
                Repeater::make('rotaciones')
                    ->relationship()
                    ->schema([
                        Grid::make(12)
                            ->schema([
                                TextInput::make('articulo_id')
                                    ->hidden(),
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
                                    ->disabled()
                                    ->readOnly()
                                    ->prefixIcon('heroicon-o-inbox-stack'),
                            ])

                    ])
                    ->collapsible()
                    ->collapsed()
                    ->itemLabel(fn ($state) => Articulo::find($state['articulo_id'])->nombre ?? 'Articulo')
                    ->columnSpanFull(),
                Textarea::make('descripcion')
                    ->required()
                    ->translateLabel()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
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
                TextColumn::make('descripcion')
                    ->translateLabel()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
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
