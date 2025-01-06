<form wire:submit="save" class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
    <div>
        <x-input-label for="codeIssuancePointInput">
            Código
        </x-input-label>
        <x-text-input
            wire:model="form.code"
            id="codeIssuancePointInput"
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
        <x-input-label for="descriptionIssuancePointInput">
            Descripción
        </x-input-label>
        <x-text-input
            wire:model="form.description"
            id="descriptionIssuancePointInput"
            maxlength="255"
            class="w-full"
        />
        @error('form.description')
            <p class="text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex items-center">
        <x-primary-button type="submit" class="mr-1">
            Guardar
        </x-primary-button>
        <div wire:loading>
            <x-icon.loading class="w-5 h-5" />
        </div>
    </div>
</form>
