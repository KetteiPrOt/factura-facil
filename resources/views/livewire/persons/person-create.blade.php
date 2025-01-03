<form wire:submit="save" class="space-y-6 p-6 text-gray-900 dark:text-gray-100">
    <div>
        <x-input-label for="identificationInput">
            Identificación
        </x-input-label>
        <x-text-input
            wire:model="form.identification"
            id="identificationInput"
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
        <x-input-label for="socialReasonInput">
            Razón Social
        </x-input-label>
        <x-text-input
            wire:model="form.social_reason"
            id="socialReasonInput"
            required
            maxlength="255"
            class="w-full"
        />
        @error('form.name')
            <p class="text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <x-input-label for="emailInput">
            Email
        </x-input-label>
        <x-text-input
            type="email"
            wire:model="form.email"
            id="emailInput"
            required
            maxlength="255"
            class="w-full"
        />
        @error('form.email')
            <p class="text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <x-input-label for="identificationTypeInput">
            Tipo de Identificación
        </x-input-label>
        <x-select-input wire:model="form.identification_type_id" id="identificationTypeInput" class="w-full" required>
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
        <x-input-label for="phoneNumberInput">
            Teléfono
        </x-input-label>
        <x-text-input
            wire:model="form.phone_number"
            id="phoneNumberInput"
            minlength="10"
            maxlength="10"
            class="w-full"
        />
        @error('form.phone_number')
            <p class="text-red-400">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <x-input-label for="addressInput">
            Dirección
        </x-input-label>
        <x-text-input
            wire:model="form.address"
            id="addressInput"
            maxlength="255"
            class="w-full"
        />
        @error('form.address')
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
