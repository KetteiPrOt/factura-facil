<div>
    <x-input-label for="issuancePointInput">
        Punto de emisión
    </x-input-label>
    <x-select-input wire:model="value" id="issuancePointInput" class="w-full" required>
        <option value="">Seleccione</option>
        @foreach($issuancePoints as $issuancePoint)
            <option value="{{$issuancePoint->id}}">
                {{$issuancePoint->code . ($issuancePoint->description
                    ? ' - ' . $issuancePoint->description
                    : ''
                )}}
            </option>
        @endforeach
    </x-select-input>
</div>
