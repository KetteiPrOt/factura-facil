@props(['paginator', 'scrollTo' => false])

@php
$pageName = $paginator->getPageName();

if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false) ? (<<<JS
    (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
JS) : '';
@endphp

<div class="flex flex-col items-center">
    <div class="flex">
        {{-- Previous Page Link --}}
        @if($paginator->onFirstPage())
            <span class="opacity-50 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-tl-md rounded-bl-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                <
            </span>
        @else
            <button wire:click="previousPage('{{$pageName}}')" wire:loading.attr="disabled" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-tl-md rounded-bl-md hover:text-gray-500 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                <
            </button>
        @endif

        {{-- Current Page Number --}}
        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">
            {{$paginator->currentPage()}} de {{$paginator->lastPage()}}
        </span>

        {{-- Next Page Link --}}
        @if($paginator->hasMorePages())
            <button wire:click="nextPage('{{$pageName}}')" wire:loading.attr="disabled" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-tr-md rounded-br-md hover:text-gray-500 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                >
            </button>
        @else
            <span class="opacity-50 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-tr-md rounded-br dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                >
            </span>
        @endif
    </div>

    {{-- Page Selector --}}
    <div
        x-data="{ changePage(n){ $wire.setPage(n, '{{$pageName}}'); } }"
        class="mt-1"
    >
        <span>Ir a:</span>
        <select id="{{$pageName}}Input" x-on:change="changePage($el.value)" class="py-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            @for($i = 1; $i <= $paginator->lastPage(); $i++)
                <option @selected($i == $paginator->currentPage())>{{$i}}</option>
            @endfor
        </select>
    </div>
</div>