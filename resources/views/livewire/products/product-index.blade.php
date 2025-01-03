<x-slot:header>
    Productos
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-end">
                    <x-input-label for="searchProductInput">
                        Productos
                    </x-input-label>
                    <x-secondary-button
                        x-data x-on:click="$dispatch('open-modal', 'create-product')"
                    >
                        Agregar
                    </x-secondary-button>
                    <x-modal name="create-product" focusable>
                        <livewire:products.product-create @product-created="$refresh" />
                    </x-modal>
                </div>
                <x-text-input
                    wire:model.live="search"
                    class="mt-1 w-full"
                    id="searchProductInput"
                    placeholder="Escribe aquí..."
                />
                <x-table.simple :col-tags="['Nombre']">
                    @forelse($products as $product)
                        <x-table.simple.tr>
                            <x-table.simple.td>
                                <span
                                    x-on:click="
                                        $dispatch('open-modal', 'edit-product');
                                        $dispatch('load-product', {product_id: {{$product->id}}})
                                    "
                                    class="inline-block w-full"
                                >
                                    {{$product->name}}
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
                <x-pagination.simple :paginator="$products" />
                <x-modal name="edit-product" focusable>
                    <livewire:products.product-edit @product-edited="$refresh" @product-deleted="$refresh" />
                </x-modal>
            </div>
        </div>
    </div>
</div>
