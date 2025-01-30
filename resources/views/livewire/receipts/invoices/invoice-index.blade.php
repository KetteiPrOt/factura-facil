<x-slot:header>
    Comprobantes
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-tg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-end">
                    <x-text.label>
                        Comprobantes
                    </x-text.label>
                </div>

                @assets @vite(['resources/js/tw-elements/collapse.js']) @endassets
                <div>
                    <div id="filtersAccordion">
                        <div class="rounded-t-lg rounded-b-lg border border-neutral-200 bg-white dark:border-neutral-600 dark:bg-gray-800">
                          <h2 wire:ignore class="mb-0" id="filtersHeading">
                            <button class="group relative flex w-full items-center rounded-t-lg rounded-b-lg border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none dark:bg-gray-800 dark:text-white [&:not([data-twe-collapse-collapsed])]:bg-white [&:not([data-twe-collapse-collapsed])]:text-primary [&:not([data-twe-collapse-collapsed])]:shadow-border-b dark:[&:not([data-twe-collapse-collapsed])]:bg-surface-dark dark:[&:not([data-twe-collapse-collapsed])]:text-primary dark:[&:not([data-twe-collapse-collapsed])]:shadow-white/10 " type="button" data-twe-collapse-init data-twe-collapse-collapsed data-twe-target="#filtersCollapse" aria-expanded="false" aria-controls="filtersCollapse">
                              Filtros
                              <span class="-me-1 ms-auto h-5 w-5 shrink-0 rotate-[-180deg] transition-transform duration-200 ease-in-out group-data-[twe-collapse-collapsed]:me-0 group-data-[twe-collapse-collapsed]:rotate-0 motion-reduce:transition-none [&>svg]:h-6 [&>svg]:w-6">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                              </span>
                            </button>
                          </h2>
                          <div wire:ignore.self id="filtersCollapse" class="!visible hidden" data-twe-collapse-item aria-labelledby="filtersHeading" data-twe-parent="#filtersAccordion">
                            <form wire:submit="applyFilters" class="space-y-6 px-5 py-4">
                                <div>
                                    <x-input-label for="dateFromInput">
                                        Fecha Inicial
                                    </x-input-label>
                                    <x-text-input
                                        wire:model="form.date_from"
                                        class="mt-1 w-full" id="dateFromInput"
                                        type="date" max="{{date('Y-m-d')}}"
                                    />
                                    @error('form.date_from') <p class="text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-input-label for="dateToInput">
                                        Fecha Final
                                    </x-input-label>
                                    <x-text-input
                                        wire:model="form.date_to"
                                        class="mt-1 w-full" id="dateToInput"
                                        type="date" max="{{date('Y-m-d')}}"
                                    />
                                    @error('form.date_to') <p class="text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-input-label for="numberInput">
                                        Número
                                    </x-input-label>
                                    <x-text-input
                                        wire:model="form.number"
                                        class="mt-1 w-full" id="numberInput"
                                        type="text"
                                    />
                                    @error('form.number') <p class="text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-input-label for="statusInput">
                                        Estado
                                    </x-input-label>
                                    <x-select-input wire:model="form.status" id="statusInput" class="w-full">
                                        <option value="">Seleccione</option>
                                        <option value="issued">Emitida</option>
                                        <option value="no-issued">No Emitida</option>
                                        <option value="authorized">Autorizada</option>
                                        <option value="no-authorized">No Autorizada</option>
                                    </x-select-input>
                                    @error('form.status') <p class="text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <div class="flex items-center">
                                    <x-primary-button type="submit" class="mr-1">
                                        Aplicar
                                    </x-primary-button>
                                    <div wire:loading>
                                        <x-icon.loading class="w-5 h-5" />
                                    </div>
                                </div>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>

                <x-table.simple :col-tags="['Fecha', 'Número', 'Estado']">
                    @forelse($receipts as $receipt)
                        <x-table.simple.tr>
                            <x-table.simple.td>
                                {{date('d/m/Y', strtotime($receipt->issuance_date))}}
                            </x-table.simple.td>
                            <x-table.simple.td>
                                <a href="{{route('invoices.download', $receipt->id)}}">
                                    {{$receipt->number}}
                                </a>
                            </x-table.simple.td>
                            <x-table.simple.td>
                                {{$receipt->status}}
                            </x-table.simple.td>
                        </x-table.simple.tr>
                    @empty
                        <x-table.simple.tr>
                            <x-table.simple.td>
                                No hay resultados.
                            </x-table.simple.td>
                            <x-table.simple.td></x-table.simple.td>
                        </x-table.simple.tr>
                    @endforelse
                </x-table.simple>
                <x-pagination.simple :paginator="$receipts" />
            </div>
        </div>
    </div>
</div>
