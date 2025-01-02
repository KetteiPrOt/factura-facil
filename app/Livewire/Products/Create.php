<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\Products\StoreForm;
use App\Models\Products\VatRate;
use Livewire\Component;

class Create extends Component
{
    public StoreForm $form;

    public function render()
    {
        return view('livewire.products.create', [
            'vatRates' => VatRate::all()
        ]);
    }

    public function save()
    {
        $product = $this->form->store();
        return $this->redirectRoute('products.show', $product->id);
    }
}
