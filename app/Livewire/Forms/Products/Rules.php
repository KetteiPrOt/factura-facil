<?php

namespace App\Livewire\Forms\Products;

use App\Models\User;
use App\Rules\Unique\For\Rule as UniqueFor;
use Illuminate\Support\Facades\Auth;

trait Rules {
    public $code;

    public $name;

    public $price;

    public $additional_info;

    public $vat_rate_id;

    /**
     * Determines whether it's storing or updating.
     * values: 'store' || 'update'
     */
    protected string $operation;

    protected function rules()
    {
        $user = User::find(Auth::user()->id);
        $uniqueFor = $this->operation == 'store'
            ? new UniqueFor($user, relation: 'products')
            : new UniqueFor($user, relation: 'products', ignore: $this->product->id);
        return [
            'code' => ['required', 'string', 'max:25', $uniqueFor],
            'name' => 'required|string|max:255',
            'price' => 'required|decimal:0,2|min:0.01|max:999999.99',
            'additional_info' => 'nullable|string|max:255',
            'vat_rate_id' => 'required|integer|exists:vat_rates,id'
        ];
    }

    protected function validationAttributes() 
    {
        return [
            'code' => 'código',
            'name' => 'nombre',
            'price' => 'precio',
            'additional_info' => 'descripción',
            'vat_rate_id' => 'IVA'
        ];
    }
}