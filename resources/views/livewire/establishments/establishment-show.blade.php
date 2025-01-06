<x-slot:header>
    Establecimiento {{$establishment->commercial_name}}
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 space-y-6 text-gray-900 dark:text-gray-100">
                <div>
                    <x-text.label>
                        Código
                    </x-text.label>
                    <x-text.p>
                        {{$establishment->code}}
                    </x-text.p>
                </div>
                <div>
                    <x-text.label>
                        Nombre comercial
                    </x-text.label>
                    <x-text.p>
                        {{$establishment->commercial_name}}
                    </x-text.p>
                </div>
                <div>
                    <x-text.label>
                        Dirección
                    </x-text.label>
                    <x-text.p>
                        {{$establishment->address}}
                    </x-text.p>
                </div>
                <div class="flex justify-between">
                    <x-primary-button x-on:click="$dispatch('open-modal', 'edit-establishment')" type="button" class="mr-1">
                        Editar
                    </x-primary-button>
            
                    <x-danger-button type="button" wire:click="destroy">
                        Eliminar
                    </x-danger-button>
                </div>
                <x-modal name="edit-establishment" focusable>
                    <livewire:establishments.establishment-edit :$establishment @establishment-edited="$refresh" />
                </x-modal>
                <div>
                    <livewire:establishments.issuance-points.issuance-point-index :$establishment />
                </div>
            </div>
        </div>
    </div>
</div>
