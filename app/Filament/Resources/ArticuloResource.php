<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticuloResource\Pages;
use App\Filament\Resources\ArticuloResource\RelationManagers;
use App\Helpers\ClaveGenerator;
use App\Helpers\Helpers;
use App\Models\Articulo;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
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
use Livewire\Component as Livewire;

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
                            ->required()
                            ->hintAction(
                                Action::make('generarClaves')
                                    ->icon('heroicon-m-cog-6-tooth')
                                    ->action(function (string|float|null $state, Set $set, Get $get, Livewire $livewire) {
                                        $claves = ClaveGenerator::generarClaves($get('nombre'));
                                        $set('clave', $claves['clave']);
                                        $set('clave_alterna', $claves['clave_alterna']);
                                    })
                            ),
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
                                    ->preload()
                                    ->afterStateUpdated(function (string|float|null $state, Set $set, Get $get) {
                                        $record = Producto::find($state);
                                        $set('costo_unitario', $record->costo_unitario ?? 0);
                                        $set('precio', Helpers::makePrecio(
                                            $record->costo_unitario ?? 0,
                                            $get('valor_equivalente'),
                                            $get('porcentaje')
                                        ));
                                    })
                                    ->live(onBlur: true),
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
                                    ->minValue(0)
                                    ->prefix('$')
                                    ->disabled()
                                    ->readOnly(),
                                TextInput::make('porcentaje')
                                    ->numeric()
                                    ->prefix('%')
                                    ->minValue(0)
                                    ->default(1)
                                    ->step(0.1),
                                TextInput::make('precio')
                                    ->numeric()
                                    ->required()
                                    ->prefix('$')
                                    ->minValue(0)
                                    ->default(0)
                                    ->step(0.01)
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Precio del artículo.')
                                    ->suffixAction(
                                        Action::make('generarPrecio')
                                            ->icon('heroicon-m-sparkles')
                                            ->action(function (string|float|null $state, Set $set, Get $get) {
                                                $set('precio',  Helpers::makePrecio(
                                                    $get('costo_unitario'),
                                                    $get('valor_equivalente'),
                                                    $get('porcentaje')
                                                ));
                                            })
                                    ),
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
