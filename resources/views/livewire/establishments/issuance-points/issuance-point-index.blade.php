<div class="pt-6" class="text-gray-900 dark:text-gray-100">
    <div class="flex justify-between items-end">
        <x-input-label for="searchIssuancePointInput">
            Puntos de Emisión
        </x-input-label>
        <x-secondary-button
            x-data x-on:click="$dispatch('open-modal', 'create-issuance-point')"
        >
            Agregar
        </x-secondary-button>
        <x-modal name="create-issuance-point" focusable>
            <livewire:establishments.issuance-points.issuance-point-create
                :$establishment
                @issuance-point-created="$refresh"
            />
        </x-modal>
    </div>
    <x-text-input
        wire:model.live="search"
        class="mt-1 w-full"
        id="searchIssuancePointInput"
        placeholder="Escribe aquí..."
    />
    <x-table.simple :col-tags="['Nombre']">
        @forelse($issuancePoints as $issuancePoint)
            <x-table.simple.tr>
                <x-table.simple.td>
                    <span
                        x-on:click="
                            $dispatch('open-modal', 'edit-issuance-point');
                            $dispatch('load-issuance-point', {issuance_point_id: {{$issuancePoint->id}}})
                        "
                        class="inline-block w-full"
                    >
                        {{$issuancePoint->code . ($issuancePoint->description
                            ? ' - ' . $issuancePoint->description
                            : ''
                        )}}
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
    <x-pagination.simple :paginator="$issuancePoints" />
    <x-modal name="edit-issuance-point" focusable>
        <livewire:establishments.issuance-points.issuance-point-edit
            :$establishment
            @issuance-point-edited="$refresh"
            @issuance-point-deleted="$refresh"
        />
    </x-modal>
</div>
