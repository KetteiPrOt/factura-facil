<div>
    <x-input-label for="clientSearchInput">
        Buscar Cliente
    </x-input-label>
    <x-text-input
        wire:model.live.debounce.500ms="search" id="clientSearchInput"
        type="text" class="mt-1 block w-full" maxlength="255"
        placeholder="Escribe aquí..."
    />
    @if($persons->isNotEmpty())
    <x-table.simple>
        @foreach($persons as $person)
            <x-table.simple.tr wire:key="{{$person->id}}">
                <x-table.simple.td>
                    <span class="whitespace-break-spaces"
                    >{{$person->social_reason}}</span>
                </x-table.simple.td>
                <x-table.simple.td>
                    <button type="button" class="w-10 h-10 p-2 inline-flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150'">
                        <x-icon.take-hand 
                            x-on:click.prevent="$wire.$parent.loadClient({{$person->id}}); $dispatch('close')"
                            class="text-white w-full h-full" 
                        />
                    </button>
                </x-table.simple.td>
            </x-table.simple.tr>
        @endforeach
    </x-table.simple>
    <x-pagination.simple :paginator="$persons" />
    @endif
</div>
