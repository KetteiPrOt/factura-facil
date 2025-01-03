<form wire:submit="save" class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
    <div>
        <x-input-label for="codeEditInput">
            Código
        </x-input-label>
        <x-text-input
            wire:model="form.code"
            x-on:open-modal.window="$el.value = ''"
            id="codeEditInput"
            required
            maxlength="25"
            class="w-full"
        />
        @error('form.code')
            <p class="text-red-400">{{ $message }}</p>
        @enderror 
    </div>
    <div>
        <x-input-label for="nameEditInput">
            Nombre
        </x-input-label>
        <x-text-input
            wire:model="form.name"
            x-on:open-modal.window="$el.value = ''"
            id="nameEditInput"
            required
            maxlength="255"
            class="w-full"
        />
        @error('form.name')
            <p class="text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <x-input-label for="priceEditInput">
            Precio
        </x-input-label>
        <div class="flex items-center">
            $<x-text-input
                type="number"
                wire:model="form.price"
                x-on:open-modal.window="$el.value = ''"
                id="priceEditInput"
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
        <x-input-label for="additionalInfoEditInput">
            Descripción
        </x-input-label>
        <x-text-input
            wire:model="form.additional_info"
            x-on:open-modal.window="$el.value = ''"
            id="additionalInfoEditInput"
            maxlength="255"
            class="w-full"
        />
        @error('form.additional_info')
            <p class="text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <x-input-label for="vatRateEditInput">
            IVA
        </x-input-label>
        <x-select-input
            wire:model="form.vat_rate_id"
            x-on:open-modal.window="$el.value = ''"
            id="vatRateEditInput" class="w-full" required
        >
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
    <div class="flex justify-between">
        <div class="flex items-center">
            <x-primary-button type="submit" class="mr-1">
                Guardar
            </x-primary-button>
            <div wire:loading>
                <x-icon.loading class="w-5 h-5" />
            </div>
        </div>

        <button type="button" wire:click="destroy" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            Eliminar
        </button>
    </div>
</form>
