<x-app-layout>
    <x-slot name="title">{{ $title ?? null }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    {{ $slot }}
</x-app-layout>
