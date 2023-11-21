<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticuloResource\Pages;
use App\Filament\Resources\ArticuloResource\RelationManagers\ArticulosRelationManager;
use App\Filament\Resources\ArticuloResource\Traits\ArticuloForms;
use App\Helpers\ClaveGenerator;
use App\Helpers\Helpers;
use App\Models\Articulo;
use App\Models\Producto;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Livewire\Component as Livewire;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Grid as LayoutGrid;
use Filament\Tables\Enums\ActionsPosition;
use Illuminate\View\View;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Milon\Barcode\Facades\DNS1DFacade;

class ArticuloResource extends Resource
{
    use ArticuloForms;

    protected static ?string $model = Articulo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('articulo')
                    ->tabs([
                        Tabs\Tab::make('Datos')
                            ->schema([
                                self::mainform()
                            ]),
                        Tabs\Tab::make('Imagenes')
                            ->schema([
                                self::imageForm()
                            ])
                            ->visible(fn (?Articulo $record) => $record !== null)

                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
                '2xl' => 4,
            ])
            ->columns([
                LayoutGrid::make(12)
                    ->schema([
                        ImageColumn::make('imagen')
                            ->size(225)
                            ->defaultImageUrl(url('/images/default_articulo.png')),
                        TextColumn::make('insumo')
                            ->badge()
                            ->formatStateUsing(fn (Articulo $articulo) => $articulo->esInsumo)
                            ->color(fn ($state): string => $state ? 'success' : 'primary')
                            ->columnSpanFull(),
                        TextColumn::make('nombre')
                            ->searchable()
                            ->sortable()
                            ->columnSpanFull(),
                        TextColumn::make('clave')
                            ->searchable()
                            ->columnSpanFull()
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('advance')
                        ->modalContent(fn (Articulo $record): View => view(
                            'barcode',
                            ['record' => $record],
                        )),
                ])
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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
