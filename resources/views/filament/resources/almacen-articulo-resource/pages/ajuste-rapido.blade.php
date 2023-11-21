<x-filament-panels::page>
    <div class="flex">
        <div class="ml-auto">
            {{ $this->createAction }}
        </div>
    </div>
    <div>
        {{ $this->form }}
    </div>
    <x-filament-actions::modals />
</x-filament-panels::page>
