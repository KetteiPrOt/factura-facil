<div>
    <x-input-label for="productSearchInput">
        Buscar Producto
    </x-input-label>
    <x-text-input
        wire:model.live.debounce.500ms="search" id="productSearchInput"
        type="text" class="mt-1 block w-full" maxlength="255"
        placeholder="Escribe aquí..."
    />
    @if($products->isNotEmpty())
    <x-table.simple>
        @foreach($products as $product)
            <x-table.simple.tr wire:key="{{$product->id}}">
                <x-table.simple.td>
                    <span class="whitespace-break-spaces"
                    >{{$product->name}}</span>
                </x-table.simple.td>
                <x-table.simple.td class="text-center">
                    <button type="button" class="w-10 h-10 p-2 inline-flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150'">
                        <x-icon.take-hand 
                            x-on:click.prevent="$wire.$parent.addProduct({{$product->id}}); $dispatch('close')"
                            class="text-white w-full h-full" 
                        />
                    </button>
                </x-table.simple.td>
            </x-table.simple.tr>
        @endforeach
    </x-table.simple>
    <x-pagination.simple :paginator="$products" />
    @endif
</div>
