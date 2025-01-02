<x-slot:header>
    Counter
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="w-16 grid grid-cols-2">
                    <h1 class="col-span-2 text-center text-lg font-bold">{{ $count }}</h1>
    
                    <button wire:click="increment" class="bg-gray-400 px-2 border rounded text-md">+</button>
                
                    <button wire:click="decrement" class="bg-gray-400 px-2 border rounded text-md">-</button>
                </div>

                <div 
                    x-data="counter" 
                    class="w-16 grid grid-cols-2"
                >
                    <h1 x-text="count" class="col-span-2 text-center text-lg font-bold"></h1>
    
                    <button x-on:click="increment()" class="bg-gray-400 px-2 border rounded text-md">+</button>
                
                    <button x-on:click="decrement()" class="bg-gray-400 px-2 border rounded text-md">-</button>
                </div>
                @script
                <script>
                    Alpine.data('counter', () => ({
                        count: 0,
                        increment(){ this.count++ },
                        decrement(){ this.count-- }
                    }));
                </script>
                @endscript
            </div>
        </div>
    </div>
</div>