<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\Products\UpdateForm;
use App\Models\Products\Product;
use App\Models\Products\VatRate;
use Livewire\Component;

class Edit extends Component
{
    public UpdateForm $form;

    public function mount(Product $product)
    {
        $this->form->setProduct($product);
    }

    public function render()
    {
        return view('livewire.products.edit', [
            'vatRates' => VatRate::all()
        ]);
    }

    public function save()
    {
        $product = $this->form->update();
        return $this->redirectRoute('products.show', $product->id);
    }
}
