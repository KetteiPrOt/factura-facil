@props([
    'col' => null, // 'string'
    'object' => null, // Entity|string
])

@if(is_null($object))
    <td class="whitespace-nowrap px-6 py-4">
        {{$slot}}
    </td>
@else
    @if(is_null($col))
        <td class="whitespace-nowrap px-6 py-4">
            {{$object}}
        </td>
    @else
        <td class="whitespace-nowrap px-6 py-4">
            {{ $object->{$col} }}
        </td>
    @endif
@endif