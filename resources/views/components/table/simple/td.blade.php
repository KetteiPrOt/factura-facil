@props([
    'col' => null, // 'string'
    'object' => null, // Entity|string
])

<td {{$attributes->merge(['class' => 'whitespace-nowrap px-6 py-4'])}}>
    @if(is_null($object))
        {{$slot}}
    @else
        @if(is_null($col))
            {{$object}}
        @else
            {{ $object->{$col} }}
        @endif
    @endif
</td>