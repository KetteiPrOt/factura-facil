<form wire:submit="save" class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
    <div>
        <x-input-label for="identificationEditInput">
            Identificación
        </x-input-label>
        <x-text-input
            wire:model="form.identification"
            id="identificationEditInput"
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

        <x-danger-button type="button" wire:click="destroy">
            Eliminar
        </x-danger-button>
    </div>
</form>
