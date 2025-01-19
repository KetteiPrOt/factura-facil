<x-slot:header>
    Facturar
</x-slot>

<div class="py-12">
    <form wire:submit="save" x-data="InvoiceComponent" x-on:invoice-created.window="reset()" class="md:grid md:grid-cols-2 md:gap-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Información de factura
                        </h2>
                    </header>

                    <div>
                        <livewire:receipts.invoices.create-inputs.establishment-input 
                            wire:model="form.establishment_id"
                        />
                        @error('form.establishment_id')
                            <p class="text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <livewire:receipts.invoices.create-inputs.issuance-point-input 
                            wire:model="form.issuance_point_id"
                        />
                        @error('form.issuance_point_id')
                            <p class="text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        @php $threeMonthAgo = date('Y-m-d', mktime(date('H'), month: date('n') - 3)); @endphp
                        <x-input-label for="issuanceDateInput" :value="'Fecha de emisión'" />
                        <x-text-input
                            wire:model="form.issuance_date"
                            id="issuanceDateInput" name="issuance_date"
                            type="date" class="mt-1 block w-full" required
                            min="{{$threeMonthAgo}}" max="{{date('Y-m-d')}}"
                        />
                        @error('form.issuance_date')
                            <p class="text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </section>
            </div>
        </div>
        <div class="mt-6 md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Información del cliente
                        </h2>
                    </header>

                    <div>
                        <x-secondary-button
                            x-on:click.prevent="$dispatch('open-modal', 'search-client')"
                        >
                            Buscar
                        </x-secondary-button>
                        <x-modal name="search-client">
                            <div class="p-6">
                                <livewire:receipts.invoices.create-inputs.search-client />
                            </div>
                        </x-modal>
                    </div>

                    <div>
                        <x-input-label for="socialReasonInput" :value="'Razón Social'" />
                        <x-text-input
                            wire:model="form.social_reason"
                            id="socialReasonInput" type="text"
                            maxlength="255" required 
                            class="mt-1 block w-full"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.social_reason')" />
                    </div>

                    <div>
                        <x-input-label for="identificationInput" :value="'Identificación'" />
                        <x-text-input
                            wire:model="form.identification"
                            id="identificationInput" type="text"
                            minlength="10" maxlength="13" required 
                            class="mt-1 block w-full"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.identification')" />
                    </div>

                    <div>
                        <x-input-label for="identificationTypeInput">
                            Tipo de Identificación
                        </x-input-label>
                        <x-select-input wire:model="form.identification_type_id" id="identificationTypeInput" class="w-full" required>
                            <option value="">Seleccione</option>
                            @foreach(
                                App\Models\Persons\IdentificationType::all()
                                as $identificationType
                            )
                                <option value="{{$identificationType->id}}">
                                    {{$identificationType->name}}
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error class="mt-2" :messages="$errors->get('form.identification_type_id')" />
                    </div>

                    <div>
                        <x-input-label for="emailInput" :value="'Email'" />
                        <x-text-input
                            wire:model="form.email"
                            id="emailInput" type="email"
                            maxlength="255" required 
                            class="mt-1 block w-full"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.email')" />
                    </div>

                    <div>
                        <x-input-label for="addressInput" :value="'Dirección'" />
                        <x-text-input
                            wire:model="form.address"
                            id="addressInput" type="text"
                            maxlength="255" class="mt-1 block w-full"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.address')" />
                    </div>

                    <div>
                        <x-input-label for="phoneNumberInput" :value="'Teléfono'" />
                        <x-text-input
                            wire:model="form.phone_number"
                            id="phoneNumberInput" type="text"
                            maxlength="10" minlength="10"
                            class="mt-1 block w-full"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.phone_number')" />
                    </div>
                </section>
            </div>
        </div>
        <div class="md:col-span-2 mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Productos
                        </h2>
                    </header>

                    <x-input-error class="mt-2" :messages="$errors->get('form.products')" />

                    @if(count($form->products) > 0)
                    <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                    <thead class="hidden md:table-header-group border-b border-neutral-200">
                        <tr>
                            <th class="px-6 py-4">Código</th>
                            <th class="px-6 py-4">Nombre</th>
                            <th class="px-6 py-4">Cantidad</th>
                            <th class="px-6 py-4">Precio</th>
                            <th class="px-6 py-4">IVA</th>
                            <th class="px-6 py-4">Descuento</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="py-2 grid sm:grid-cols-2 md:table-row-group sm:px-6 lg:px-8">
                        @foreach($form->products as $key => $data)
                        <tr wire:key="{{$data['id']}}" class="grid grid-cols-2 md:table-row border-b border-neutral-200 transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-white/10 dark:hover:bg-neutral-600">
                            @php $product = App\Models\Products\Product::find($data['id']); @endphp
                            <td class="row-start-2 row-end-3 col-span-1 inline-block md:table-cell whitespace-nowrap ps-6 md:pe-6 md:py-4">
                                <x-text.label class="md:hidden">
                                    Código
                                </x-text.label>
                                <x-text.p class="md:hidden overflow-x-auto">
                                    {{$product->code}}
                                </x-text.p>
                                <span class="hidden md:inline">{{$product->code}}</span>
                                <x-input-error class="mt-2" :messages="$errors->get('form.products.{{$key}}.id')" />
                                <x-input-error class="mt-2" :messages="$errors->get('form.products.{{$key}}')" />
                            </td>
                            <td class="row-start-1 row-end-2 col-span-2 block md:table-cell whitespace-nowrap px-6 pt-4 md:pb-4">
                                <div class="mb-1 flex justify-between items-end md:hidden">
                                    <x-text.label>
                                        Nombre
                                    </x-text.label>
                                    <x-danger-button 
                                        type="button" 
                                        x-on:click.prevent="
                                            clearProduct({{$key}}, {{$product->vatRate->code}});
                                            $wire.removeProduct({{$key}})
                                        "
                                    >
                                        Quitar
                                    </x-danger-button>
                                </div>
                                <x-text.p
                                    class="md:hidden max-w-full whitespace-break-spaces"
                                >{{$product->name}}</x-text.p>
                                <span class="hidden md:inline">{{$product->name}}</span>
                            </td>
                            <td class="row-start-3 row-end-4 col-span-2 inline-block md:table-cell whitespace-nowrap px-6 md:py-4">
                                <x-input-label class="md:hidden" for="productAmountInput{{$key}}" value="Cantidad" />
                                <x-text-input
                                    wire:model="form.products.{{$key}}.amount" type="number"
                                    id="productAmountInput{{$key}}" class="block w-full"
                                    min="1" max="999" required
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('form.products.{{$key}}.amount')" />
                            </td>
                            <td class="row-start-4 row-end-5 col-span-2 inline-block md:table-cell whitespace-nowrap px-6 md:py-4">
                                <x-input-label class="md:hidden" for="productPriceInput{{$key}}" value="Precio" />
                                <x-text-input
                                    wire:model="form.products.{{$key}}.price" type="number"
                                    id="productPriceInput{{$key}}" class="block w-full"
                                    min="0.01" max="999999.99" step="0.01" required
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('form.products.{{$key}}.price')" />
                            </td>
                            <td class="row-start-2 row-end-3 col-span-1 inline-block md:table-cell whitespace-nowrap pe-6 md:ps-6 md:py-4">
                                <x-text.label class="md:hidden">
                                    IVA
                                </x-text.label>
                                <x-text.p class="md:hidden">
                                    {{$product->vatRate->name}}
                                </x-text.p>
                                <span class="hidden md:inline">{{$product->vatRate->name}}</span>
                            </td>
                            <td class="row-start-5 row-end-6 col-span-2 inline-block md:table-cell whitespace-nowrap px-6 md:py-4">
                                <x-input-label class="md:hidden" for="productDiscountInput{{$key}}" value="Descuento" />
                                <x-text-input
                                    wire:model="form.products.{{$key}}.discount" type="number"
                                    id="productDiscountInput{{$key}}" class="block w-full"
                                    min="0" max="999999.99" step="0.01"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('form.products.{{$key}}.discount')" />
                            </td>
                            <td class="row-start-6 row-end-7 col-span-2 inline-block md:table-cell whitespace-nowrap px-6 pb-4 md:pt-4">
                                <x-text.label class="md:hidden">
                                    Total
                                </x-text.label>
                                <x-text.p
                                    x-text="productTotal(
                                        {{$key}},
                                        $wire.form.products[{{$key}}], 
                                        {{$product->vatRate->code}}
                                    )"
                                    class="max-w-full whitespace-break-spaces"
                                ></x-text.p>
                            </td>
                            <td class="row-start-7 row-end-8 col-span-2 hidden md:table-cell whitespace-nowrap px-6 md:py-4">
                                <x-danger-button 
                                    type="button" 
                                    x-on:click.prevent="
                                        clearProduct({{$key}}, {{$product->vatRate->code}});
                                        $wire.removeProduct({{$key}})
                                    "
                                >
                                    Quitar
                                </x-danger-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    </div>
                    </div>
                    @endif

                    <div>
                        <x-secondary-button
                            x-on:click.prevent="$dispatch('open-modal', 'search-product')"
                        >
                            Buscar
                        </x-secondary-button>
                        <x-modal name="search-product">
                            <div class="p-6">
                                <livewire:receipts.invoices.create-inputs.search-product 
                                    :$selected
                                />
                            </div>
                        </x-modal>
                    </div>
                </section>
            </div>
        </div>
        <div class="md:col-start-2 md:col-end-3 mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Totales
                        </h2>
                    </header>

                    <div>
                        <x-table.simple>
                            <x-table.simple.tr>
                                <x-table.simple.td>
                                    Sin impuestos
                                </x-table.simple.td>
                                <x-table.simple.td>
                                    <span x-text="sum('without_taxes')"></span>
                                </x-table.simple.td>
                            </x-table.simple.tr>
                            <x-table.simple.tr>
                                <x-table.simple.td>
                                    Subtotal 15%
                                </x-table.simple.td>
                                <x-table.simple.td>
                                    <span x-text="sum('subtotal_15')"></span>
                                </x-table.simple.td>
                            </x-table.simple.tr>
                            <x-table.simple.tr>
                                <x-table.simple.td>
                                    Subtotal 5%
                                </x-table.simple.td>
                                <x-table.simple.td>
                                    <span x-text="sum('subtotal_5')"></span>
                                </x-table.simple.td>
                            </x-table.simple.tr>
                            <x-table.simple.tr>
                                <x-table.simple.td>
                                    Subtotal 0%
                                </x-table.simple.td>
                                <x-table.simple.td>
                                    <span x-text="sum('subtotal_0')"></span>
                                </x-table.simple.td>
                            </x-table.simple.tr>
                            <x-table.simple.tr>
                                <x-table.simple.td>
                                    Subtotal no objeto de IVA
                                </x-table.simple.td>
                                <x-table.simple.td>
                                    <span x-text="sum('subtotal_no_vat')"></span>
                                </x-table.simple.td>
                            </x-table.simple.tr>
                            <x-table.simple.tr>
                                <x-table.simple.td>
                                    Subtotal exento de IVA
                                </x-table.simple.td>
                                <x-table.simple.td>
                                    <span x-text="sum('subtotal_vat_exempt')"></span>
                                </x-table.simple.td>
                            </x-table.simple.tr>
                            <x-table.simple.tr>
                                <x-table.simple.td>
                                    IVA 15%
                                </x-table.simple.td>
                                <x-table.simple.td>
                                    <span x-text="sum('tax_15')"></span>
                                </x-table.simple.td>
                            </x-table.simple.tr>
                            <x-table.simple.tr>
                                <x-table.simple.td>
                                    IVA 5%
                                </x-table.simple.td>
                                <x-table.simple.td>
                                    <span x-text="sum('tax_5')"></span>
                                </x-table.simple.td>
                            </x-table.simple.tr>
                            <x-table.simple.tr>
                                <x-table.simple.td>
                                    Valor a pagar
                                </x-table.simple.td>
                                <x-table.simple.td>
                                    <span x-text="total()"></span>
                                </x-table.simple.td>
                            </x-table.simple.tr>
                        </x-table.simple>
                    </div>
                </section>
            </div>
        </div>
        <div class="md:self-start md:row-start-4 md:row-end-5 md:col-start-1 md:col-end-2 mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Formas de pago
                        </h2>
                    </header>

                    <div>
                        <x-input-label for="payMethodInput">
                            Tipo de forma de pago
                        </x-input-label>
                        <x-select-input wire:model="form.pay_method_id" id="payMethodInput" class="w-full" required>
                            <option value="">Seleccione</option>
                            @foreach(
                                App\Models\Receipts\PayMethod::all()
                                as $payMethod
                            )
                                <option value="{{$payMethod->id}}">
                                    {{$payMethod->name}}
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error class="mt-2" :messages="$errors->get('form.pay_method_id')" />
                    </div>

                    <div class="flex items-center">
                        <x-primary-button type="submit" class="mr-1">
                            Guardar
                        </x-primary-button>
                        <div wire:loading>
                            <x-icon.loading class="w-5 h-5" />
                        </div>

                        <x-action-message class="ms-3" on="invoice-created">
                            Guardado!
                        </x-action-message>
                    </div>
                </section>
            </div>
        </div>
    </form>
</div>
