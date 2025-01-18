<div>
    <x-input-label for="establishmentInput">
        Establecimiento
    </x-input-label>
    <x-select-input 
        wire:model="value" 
        @change="$dispatch('establishment-changed', {establishmentId: $el.value})"
        id="establishmentInput" 
        class="w-full" required
    >
        <option value="">Seleccione</option>
        @foreach($establishments as $establishment)
            <option value="{{$establishment->id}}">
                {{$establishment->code}} - {{$establishment->commercial_name}}
            </option>
        @endforeach
    </x-select-input>
</div>
