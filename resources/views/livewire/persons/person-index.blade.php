<x-slot:header>
    Clientes
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-end">
                    <x-input-label for="searchPersonInput">
                        Clientes
                    </x-input-label>
                    <x-secondary-button
                        x-data x-on:click="$dispatch('open-modal', 'create-person')"
                    >
                        Agregar
                    </x-secondary-button>
                    <x-modal name="create-person" focusable>
                        <livewire:persons.person-create @person-created="$refresh" />
                    </x-modal>
                </div>
                <x-text-input
                    wire:model.live="search"
                    class="mt-1 w-full"
                    id="searchPersonInput"
                    placeholder="Escribe aquí..."
                />
                <x-table.simple :col-tags="['Razón Social']">
                    @forelse($persons as $person)
                        <x-table.simple.tr>
                            <x-table.simple.td>
                                <span
                                    x-on:click="
                                        $dispatch('open-modal', 'edit-person');
                                        $dispatch('load-person', {person_id: {{$person->id}}})
                                    "
                                    class="inline-block w-full"
                                >
                                    {{$person->social_reason}}
                                </span>
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
                <x-pagination.simple :paginator="$persons" />
                <x-modal name="edit-person" focusable>
                    <livewire:persons.person-edit @person-edited="$refresh" @person-deleted="$refresh" />
                </x-modal>
            </div>
        </div>
    </div>
</div>
