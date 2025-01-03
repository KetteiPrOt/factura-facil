<form wire:submit="save" class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
    <div>
        <x-input-label for="identificationEditInput">
            Identificación
        </x-input-label>
        <x-text-input
            wire:model="form.identification"
            id="identificationEditInput"
            x-on:open-modal.window="$el.value = ''"
            required
            minlength="10"
            maxlength="13"
            class="w-full"
        />
        @error('form.identification')
            <p class="text-red-400">{{ $message }}</p>
        @enderror 
    </div>
    <div>
        <x-input-label for="socialReasonEditInput">
            Razón Social
        </x-input-label>
        <x-text-input
            wire:model="form.social_reason"
            id="socialReasonEditInput"
            x-on:open-modal.window="$el.value = ''"
            required
            maxlength="255"
            class="w-full"
        />
        @error('form.name')
            <p class="text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <x-input-label for="emailEditInput">
            Email
        </x-input-label>
        <x-text-input
            type="email"
            wire:model="form.email"
            id="emailEditInput"
            x-on:open-modal.window="$el.value = ''"
            required
            maxlength="255"
            class="w-full"
        />
        @error('form.email')
            <p class="text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <x-input-label for="identificationTypeEditInput">
            Tipo de Identificación
        </x-input-label>
        <x-select-input
            wire:model="form.identification_type_id"
            x-on:open-modal.window="$el.value = ''"
            id="identificationTypeEditInput"
            class="w-full" required
        >
            <option>Seleccione</option>
            @foreach($identificationTypes as $identificationType)
                <option value="{{$identificationType->id}}">
                    {{$identificationType->name}}
                </option>
            @endforeach
        </x-select-input>
        @error('form.identification_type_id')
            <p class="text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <x-input-label for="phoneNumberEditInput">
            Teléfono
        </x-input-label>
        <x-text-input
            wire:model="form.phone_number"
            id="phoneNumberEditInput"
            x-on:open-modal.window="$el.value = ''"
            minlength="10"
            maxlength="10"
            class="w-full"
        />
        @error('form.phone_number')
            <p class="text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <x-input-label for="addressEditInput">
            Dirección
        </x-input-label>
        <x-text-input
            wire:model="form.address"
            id="addressEditInput"
            x-on:open-modal.window="$el.value = ''"
            maxlength="255"
            class="w-full"
        />
        @error('form.address')
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
