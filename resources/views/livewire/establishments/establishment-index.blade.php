<x-slot:header>
    Establecimientos
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-end">
                    <x-input-label for="searchEstablishmentInput">
                        Establecimientos
                    </x-input-label>
                    <x-secondary-button
                        x-data x-on:click="$dispatch('open-modal', 'create-establishment')"
                    >
                        Agregar
                    </x-secondary-button>
                    <x-modal name="create-establishment" focusable>
                        <livewire:establishments.establishment-create @establishment-created="$refresh" />
                    </x-modal>
                </div>
                <x-text-input
                    wire:model.live="search"
                    class="mt-1 w-full"
                    id="searchEstablishmentInput"
                    placeholder="Escribe aquí..."
                />
                <x-table.simple :col-tags="['Nombre Comercial']">
                    @forelse($establishments as $establishment)
                        <x-table.simple.tr>
                            <x-table.simple.td>
                                <a
                                    href="{{route('establishments.show', $establishment->id)}}"
                                    class="inline-block w-full" wire:navigate
                                >
                                    {{$establishment->commercial_name}}
                                </a>
                            </x-table.simple.td>
                        </x-table.simple.tr>
                    @empty
                        <x-table.simple.tr>
                            <x-table.simple.td>
                                No hay resultados{{$search ? " para '$search'" : ''}}.
                            </x-table.simple.td>
                        </x-table.simple.tr>
                    @endforelse
                </x-table.simple>
                <x-pagination.simple :paginator="$establishments" />
            </div>
        </div>
    </div>
</div>
