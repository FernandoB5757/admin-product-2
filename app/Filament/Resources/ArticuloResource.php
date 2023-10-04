<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticuloResource\Pages;
use App\Filament\Resources\ArticuloResource\RelationManagers;
use App\Models\Articulo;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticuloResource extends Resource
{
    protected static ?string $model = Articulo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns(12)
                    ->schema([
                        TextInput::make('nombre')
                            ->columnSpan([
                                'md' => 8,
                            ])
                            ->required(),
                        Toggle::make('insumo')
                            ->columnSpan([
                                'md' => 4,
                            ])
                            ->hint('¿El artículo es un insumo?')
                            ->columnSpanFull(),
                        TextInput::make('clave')
                            ->columnSpan([
                                'md' => 8,
                            ])
                            ->required(),
                        TextInput::make('clave_alterna')
                            ->columnSpan([
                                'md' => 4,
                            ])
                            ->required(),
                        Fieldset::make('Producto')
                            ->schema([
                                Select::make('producto_id')
                                    ->relationship(name: 'producto', titleAttribute: 'nombre')
                                    ->columnSpan([
                                        'md' => 8,
                                    ])
                                    ->required()
                                    ->searchable(['nombre'])
                                    ->preload(),
                                TextInput::make('valor_equivalente')
                                    ->columnSpan([
                                        'md' => 4,
                                    ])
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->prefixIcon('heroicon-o-inbox-stack')
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Ejemplo: Equivale a 4 litros de producto X.'),
                            ])
                            ->columns(12),
                        Fieldset::make('Costos')
                            ->schema([
                                TextInput::make('costo_unitario')
                                    ->numeric()
                                    ->required()
                                    ->step(0.1)
                                    ->minValue(0)
                                    ->default(0)
                                    ->prefix('$'),
                                TextInput::make('porcentaje')
                                    ->numeric()
                                    ->prefix('%')
                                    ->minValue(0)
                                    ->default(0)
                                    ->step(0.1)
                                    ->afterStateUpdated(function (string|float|null $state, Set $set, Get $get) {
                                        $costo_unitario = floatval($get('costo_unitario') ?? 0);
                                        $valor_equivalente = floatval($get('valor_equivalente') ?? 0);
                                        $porcentaje = floatval($state ?? 0) *  0.01;
                                        $porcentaje = floatval($state ?? 0) *  0.01;
                                        $margen = $costo_unitario * $porcentaje;
                                        $precio = $margen + $costo_unitario * $valor_equivalente;
                                        $set('precio', $precio);
                                    })
                                    ->live(),
                                TextInput::make('precio')
                                    ->numeric()
                                    ->required()
                                    ->prefix('$')
                                    ->minValue(0)
                                    ->default(0)
                                    ->step(0.1)
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Precio del artículo.'),
                                Toggle::make('usa_embace')
                                    ->columnSpanFull()
                                    ->helperText('¿El artículo usa embace?')
                                    ->live(),
                                TextInput::make('precio_embase')
                                    ->numeric()
                                    ->prefix('$')
                                    ->minValue(0)
                                    ->step(0.1)
                                    ->requiredIf('usa_embace', true)
                                    ->columnSpanFull()
                                    ->hidden(fn (Get $get): bool => !$get('usa_embace')),
                            ])
                            ->columns(3),
                        Textarea::make('descripcion')
                            ->columnSpanFull()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('clave')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Articulo $articulo) => $articulo?->clave_alterna),
                TextColumn::make('valor_equivalente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('precio')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (Articulo $articulo) => $articulo->precioFormat),
                IconColumn::make('usa_embace')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('insumo')
                    ->badge()
                    ->formatStateUsing(fn (Articulo $articulo) => $articulo->esInsumo)
                    ->color(fn ($state): string => $state ? 'success' : 'primary')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListArticulos::route('/'),
            'create' => Pages\CreateArticulo::route('/create'),
            'edit' => Pages\EditArticulo::route('/{record}/edit'),
        ];
    }
}
