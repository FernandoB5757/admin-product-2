<?php

namespace App\Filament\Resources;

use App\Actions\Corte\CreateNewCorte;
use App\Filament\Resources\CorteResource\Pages;
use App\Filament\Resources\CorteResource\RelationManagers;
use App\Models\Corte;
use App\Models\Enums\EstatusCorte;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CorteResource extends Resource
{
    protected static ?string $model = Corte::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('dinero_apertura')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->step(0.1)
                    ->prefixIcon('heroicon-o-currency-dollar')
                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Dinero en caja actual.'),
                Select::make('caja_id')
                    ->relationship(name: 'caja', titleAttribute: 'nombre')
                    ->searchable()
                    ->preload()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('estatus')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('dinero_apertura')
                    ->formatStateUsing(fn (Corte $record) => $record->aperturaFormat)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('dinero_cierre')
                    ->formatStateUsing(fn (Corte $record) => $record->cierreFormat)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('fecha_apertura')
                    ->formatStateUsing(fn (Corte $record) => Carbon::parse($record->fecha_apertura)->format('d/m/Y H:i:s'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('fecha_cierre')
                    ->formatStateUsing(fn (Corte $record) => $record->fecha_cierre ?  Carbon::parse($record->fecha_apertura)->format('d/m/Y H:i:s') : 'Sin cerrar')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
            ])
            ->filters([
                SelectFilter::make('estatus')
                    ->options(
                        EstatusCorte::class
                    )
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                ]),
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
            'index' => Pages\ListCortes::route('/'),
            'create' => Pages\CreateCorte::route('/create'),
            'edit' => Pages\EditCorte::route('/{record}/edit'),
        ];
    }
}
