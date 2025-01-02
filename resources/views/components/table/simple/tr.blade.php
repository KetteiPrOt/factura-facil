@props([
    'cols' => [], // ['name', 'email', 'phone']
    'object' => null, // Entity|string
])

<tr
{{$attributes}}
class="border-b border-neutral-200 transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-white/10 dark:hover:bg-neutral-600">
@if(is_null($object))
    {{$slot}}
@else
    @forelse($cols as $col)
        <x-table.simple.td :$object :$col />
    @empty
        <x-table.simple.td :$object />
    @endforelse
@endif
</tr>