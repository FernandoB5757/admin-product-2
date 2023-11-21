<?php

namespace App\Filament\Resources\AlmacenArticuloResource\Pages;

use App\Actions\Almacen\UpdateStock;
use App\Filament\Resources\AlmacenArticuloResource;
use App\Helpers\Helpers;
use App\Models\Almacen;
use App\Models\AlmacenArticulo;
use App\Models\Articulo;
use App\Models\Enums\TipoRotacion;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\ActionSize;
use Livewire\Component as Livewire;

class AjusteRapido extends Page implements HasForms, HasActions
{
    use InteractsWithForms;

    protected static string $resource = AlmacenArticuloResource::class;

    protected static string $view = 'filament.resources.almacen-articulo-resource.pages.ajuste-rapido';

    public ?array $data = [];
    public int $almacenId = 1;

    public function mount(?int $almacen = 1): void
    {
        $this->almacenId = $almacen;
        $this->data = [
            'almacen' => Almacen::findorFail($almacen)?->nombre
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('almacen')
                    ->disabled()
                    ->readOnly()
                    ->columnSpanFull(),
                Textarea::make('descripcion')
                    ->required()
                    ->translateLabel()
                    ->columnSpanFull(),
                Repeater::make('ajustes')
                    ->schema([
                        Grid::make(12)
                            ->schema([
                                Select::make('articulo_id')
                                    ->label('Articulo')
                                    ->options(options: function (
                                        Get $get,
                                        string|int|null $state
                                    ) {
                                        $ids = Helpers::getNoRepetId($get('../../ajustes'), $state ?? 0);
                                        return Articulo::query()->whereNotIn('id', $ids)
                                            ->get()->pluck('nombre', 'id')->toArray();
                                    })
                                    ->getSearchResultsUsing(
                                        function (string $search, Get $get): array {
                                            $ids = Helpers::getNoRepetId($get('../../ajustes'), $state ?? 0);
                                            return Articulo::where('nombre', 'like', "%{$search}%")
                                                ->orWhere('clave', $search)
                                                ->whereNotIn('id', $ids)
                                                ->limit(10)
                                                ->pluck('nombre', 'id')
                                                ->toArray();
                                        }
                                    )
                                    ->afterStateUpdated(
                                        function (?string $state, Set $set): void {
                                            $articuloAlmacen = AlmacenArticulo::findRegister($state ?? 0);
                                            $set('stock_antes', $articuloAlmacen->stock ?? 0);
                                        }
                                    )
                                    ->searchable()
                                    ->columnSpanFull()
                                    ->live(onBlur: true),
                                TextInput::make('stock_antes')
                                    ->columnSpan([
                                        'sm' => 12,
                                        'md' => 6
                                    ])
                                    ->required()
                                    ->readOnly()
                                    ->numeric()
                                    ->prefixIcon('heroicon-o-inbox-stack'),
                                TextInput::make('stock')
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
                    ->collapsible()
                    ->minItems(1)
                    ->defaultItems(1)
                    ->itemLabel('Articulo')
                    ->columnSpanFull()
            ])
            ->statePath('data');
    }

    public function createAction(): Action
    {
        return CreateAction::make()
            ->label('Guardar ajuste')
            ->requiresConfirmation()
            ->modalHeading('Guardar ajuste')
            ->modalDescription('¿Estas seguro de guardar los ajustes? Se actualizaran las existencias.')
            ->modalIcon('heroicon-o-inbox-arrow-down')
            ->createAnother(false)
            ->size(ActionSize::Large)
            ->action(fn () => $this->create());
    }


    public function create(): void
    {
        $data = $this->form->getState();

        $ajustes = $data['ajustes'];

        try {
            UpdateStock::updateOrCreateMultiple(
                $ajustes,
                [
                    'tipo' => TipoRotacion::Ajuste,
                    'user_id' => auth()->user()->id,
                    'almacen_id' => $this->almacenId,
                    'descripcion' => $data['descripcion'],
                ],
                $this->almacenId
            );
        } catch (Exception $e) {
            Notification::make()
                ->title('Hubo un error')
                ->danger()
                ->body($e->getMessage())
                ->send();
            return;
        }
        Notification::make()
            ->title('Ajustes guardado con exito.')
            ->success()
            ->send();
        $this->form->fill();
    }
}
