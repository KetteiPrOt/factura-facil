@props([
    'colTags' => [], // ['Nombre', 'Email', 'Teléfono']
    'cols' => [], // ['name', 'email', 'phone']
    'objects' => [], // Collection|array
])

<div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <table
            class="min-w-full text-left text-sm font-light text-surface dark:text-white">
            <thead
                class="border-b border-neutral-200 font-medium dark:border-white/10">
                <tr>
                @foreach($colTags as $colTag)
                    <th scope="col" class="px-6 py-4">{{$colTag}}</th>
                @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($objects as $object)
                    <x-table.simple.tr :$object :$cols />
                @empty
                    {{$slot}}
                @endforelse
            </tbody>
            </table>
        </div>
        </div>
    </div>
  </div>