<?php

namespace App\Filament\Resources\ArticuloResource\RelationManagers;

use App\Filament\Resources\ArticuloResource\Traits\ArticuloForms;
use App\Models\Articulo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticulosRelationManager extends RelationManager
{
    use ArticuloForms;

    protected static string $relationship = 'articulos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                self::mainform()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('clave')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Articulo $articulo) => $articulo?->clave_alterna),
                TextColumn::make('valor_equivalente')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Articulo $articulo) => "Equivale a {$articulo->valor_equivalente} {$articulo->producto->unidadNombre} de {$articulo->producto->nombre}"),
                TextColumn::make('precio')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (Articulo $articulo) => $articulo->precioFormat),
                IconColumn::make('usa_embace')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('insumo')
                    ->badge()
                    ->label('Tipo')
                    ->formatStateUsing(fn (Articulo $articulo) => $articulo->esInsumo)
                    ->color(fn ($state): string => $state ? 'success' : 'primary'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
