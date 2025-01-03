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
            
                    <button wire:click="destroy" type="button" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Eliminar
                    </button>
                </div>
                <x-modal name="edit-establishment" focusable>
                    <livewire:establishments.establishment-edit :$establishment @establishment-edited="$refresh" />
                </x-modal>
            </div>
        </div>
    </div>
</div>
