<x-slot:header>
    Crear producto
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <form wire:submit="save" class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
                <div>
                    <x-input-label for="codeInput">
                        Código
                    </x-input-label>
                    <x-text-input
                        wire:model="form.code"
                        id="codeInput"
                        required
                        maxlength="25"
                        class="w-full"
                    />
                    @error('form.code')
                        <p class="text-red-400">{{ $message }}</p>
                    @enderror 
                </div>
                <div>
                    <x-input-label for="nameInput">
                        Nombre
                    </x-input-label>
                    <x-text-input
                        wire:model="form.name"
                        id="nameInput"
                        required
                        maxlength="255"
                        class="w-full"
                    />
                    @error('form.name')
                        <p class="text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-input-label for="priceInput">
                        Precio
                    </x-input-label>
                    <div class="flex items-center">
                        $<x-text-input
                            type="number"
                            wire:model="form.price"
                            id="priceInput"
                            min="0.01"
                            max="999999.99"
                            step="0.01"
                            required
                            maxlength="255"
                            class="w-full"
                        />
                    </div>
                    @error('form.price')
                        <p class="text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-input-label for="additionalInfoInput">
                        Descripción
                    </x-input-label>
                    <x-text-input
                        wire:model="form.additional_info"
                        id="additionalInfoInput"
                        maxlength="255"
                        class="w-full"
                    />
                    @error('form.additional_info')
                        <p class="text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-input-label for="vatRateInput">
                        IVA
                    </x-input-label>
                    <x-select-input wire:model="form.vat_rate_id" id="vatRateInput" class="w-full" required>
                        <option>Seleccione</option>
                        @foreach($vatRates as $vatRate)
                            <option value="{{$vatRate->id}}">
                                {{$vatRate->percentaje}}%
                            </option>
                        @endforeach
                    </x-select-input>
                    @error('form.vat_rate_id')
                        <p class="text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-primary-button type="submit">
                        Guardar
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
