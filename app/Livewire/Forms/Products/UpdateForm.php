<?php

namespace App\Livewire\Forms\Products;

use App\Models\Products\Product;
use Livewire\Form;

class UpdateForm extends Form
{
    use Rules;

    public Product $product;

    public function setProduct($product)
    {
        $this->product = $product;
        $this->fill([
            'code' => $product->code,
            'name' => $product->name,
            'price' => $product->price,
            'additional_info' => $product->additional_info,
            'vat_rate_id' => $product->vat_rate_id,
        ]);
    }

    public function update()
    {
        $this->validate();
        $this->product->update($this->all());
        return $this->product;
    }
}

