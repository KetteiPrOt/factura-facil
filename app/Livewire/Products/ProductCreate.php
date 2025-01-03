<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\Products\StoreForm;
use App\Models\Products\VatRate;
use Livewire\Component;

class ProductCreate extends Component
{
    public StoreForm $form;

    public function render()
    {
        return view('livewire.products.product-create', [
            'vatRates' => VatRate::all()
        ]);
    }

    public function save()
    {
        $this->form->store();
        $this->form->reset();
        $this->dispatch('close');
        $this->dispatch('product-created');
    }
}
