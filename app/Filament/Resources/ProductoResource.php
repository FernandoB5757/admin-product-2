<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticuloResource\RelationManagers\ArticulosRelationManager;
use App\Filament\Resources\ProductoResource\Pages;
use App\Filament\Resources\ProductoResource\RelationManagers;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\SubCategoria;
use App\Models\Unidad;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        TextInput::make('nombre')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Fieldset::make('Categoria')
                            ->schema([
                                Select::make('categoria')
                                    ->options(Categoria::query()->pluck('nombre', 'id'))
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('sub_categoria_id', null);
                                    })
                                    ->live(onBlur: true),
                                Select::make('sub_categoria_id')
                                    ->required()
                                    ->searchable()
                                    ->options(fn (Get $get): Collection => SubCategoria::getOptions($get('categoria')))
                                    ->preload()
                            ])
                            ->columns(2),
                        Fieldset::make('Unidades')
                            ->schema([
                                TextInput::make('cantidad_minima')
                                    ->translateLabel()
                                    ->numeric()
                                    ->required()
                                    ->minValue(0),
                                Select::make('unidad_id')
                                    ->translateLabel()
                                    ->options(Unidad::all()->pluck('nombre', 'id'))
                                    ->searchable()
                                    ->required()
                            ])
                            ->columns(2),
                        Fieldset::make('Costos')
                            ->schema([
                                TextInput::make('costo_unitario')
                                    ->translateLabel()
                                    ->numeric()
                                    ->required()
                                    ->prefix('$')
                                    ->minValue(0),
                                TextInput::make('costo')
                                    ->translateLabel()
                                    ->numeric()
                                    ->required()
                                    ->prefix('$')
                                    ->minValue(0),
                            ])
                            ->columns(2)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('unidad.nombre')
                    ->searchable(),
                TextColumn::make('cantidad_minima'),
                TextColumn::make('costo')
                    ->formatStateUsing(fn (Producto $record): string => $record->costoFormat),
                TextColumn::make('costo_unitario')
                    ->formatStateUsing(fn (Producto $record): string => $record->costounitarioFormat),
                TextColumn::make('subcategoria.nombre')
                    ->searchable()
            ])
            ->filters([
                SelectFilter::make('unidad')
                    ->relationship('unidad', 'nombre')
                    ->preload()
                    ->searchable()
                    ->multiple(),
                SelectFilter::make('subcategoria')
                    ->relationship('subcategoria', 'nombre')
                    ->preload()
                    ->searchable()
                    ->multiple()
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
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
            ArticulosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
