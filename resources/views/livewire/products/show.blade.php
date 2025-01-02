<x-slot:header>
    Producto
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
                <div>
                    <x-text.label>
                        Código
                    </x-text.label>
                    <x-text.p>
                        {{$product->code}}
                    </x-text.p>
                </div>
                <div>
                    <x-text.label>
                        Nombre
                    </x-text.label>
                    <x-text.p>
                        {{$product->name}}
                    </x-text.p>
                </div>
                <div>
                    <x-text.label>
                        Precio
                    </x-text.label>
                    <x-text.p>
                        ${{$product->price}}
                    </x-text.p>
                </div>
                <div>
                    <x-text.label>
                        Descripción
                    </x-text.label>
                    <x-text.p>
                        {{$product->additional_info ?? 'Ninguna.'}}
                    </x-text.p>
                </div>
                <div>
                    <x-text.label>
                        IVA
                    </x-text.label>
                    <x-text.p>
                        {{$product->vatRate->percentaje}}%
                    </x-text.p>
                </div>
                <div class="flex justify-between">
                    <a href="{{route('products.edit', $product->id)}}" wire:navigate>
                        <x-primary-button>
                            Editar
                        </x-primary-button>
                    </a>

                    <button type="button" wire:click="destroy" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
