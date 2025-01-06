<form wire:submit="save" class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
    <div>
        <x-input-label for="codeIssuancePointEditInput">
            Código
        </x-input-label>
        <x-text-input
            wire:model="form.code"
            id="codeIssuancePointEditInput"
            required
            min="1"
            max="999"
            class="w-full"
        />
        @error('form.code')
            <p class="text-red-400">{{ $message }}</p>
        @enderror 
    </div>
    <div>
        <x-input-label for="descriptionIssuancePointEditInput">
            Descripción
        </x-input-label>
        <x-text-input
            wire:model="form.description"
            id="descriptionIssuancePointEditInput"
            maxlength="255"
            class="w-full"
        />
        @error('form.description')
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
