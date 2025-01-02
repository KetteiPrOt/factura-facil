<?php

namespace App\Livewire\Forms\Products;

use Livewire\Attributes\Validate;

trait Rules {
    #[Validate]
    public $code;

    #[Validate]
    public $name;

    #[Validate]
    public $price;

    #[Validate]
    public $additional_info;

    #[Validate]
    public $vat_rate_id;

    protected function rules()
    {
        return [
            'code' => 'required|string|max:25',
            'name' => 'required|string|max:255',
            'price' => 'required|decimal:0,2|min:0.01|max:999999.99',
            'additional_info' => 'nullable|string|max:255',
            'vat_rate_id' => 'required|integer|exists:vat_rates,id'
        ];
    }
}