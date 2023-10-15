<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnidadResource\Pages;
use App\Filament\Resources\UnidadResource\RelationManagers;
use App\Models\Unidad;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnidadResource extends Resource
{
    protected static ?string $model = Unidad::class;

    protected static ?string $modelLabel = 'unidad de medida';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $pollingInterval = '10s';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        TextInput::make('clave')
                            ->columnSpan([
                                'md' => 6,
                            ])
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('nombre')
                            ->columnSpan([
                                'md' => 6,
                            ])
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Textarea::make('descripcion')
                            ->translateLabel()
                            ->columnSpanFull()
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('clave')
                    ->sortable()
                    ->searchable()
                    ->copyable(),
                TextColumn::make('nombre')
                    ->sortable()
                    ->searchable()
                    ->copyable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->hidden(function (Unidad $record): bool {
                            return $record->hasProductos();
                        }),
                ])
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUnidads::route('/'),
        ];
    }
}
