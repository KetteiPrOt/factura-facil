<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\Products\UpdateForm;
use App\Models\Products\Product;
use App\Models\Products\VatRate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductEdit extends Component
{
    public UpdateForm $form;

    #[On('load-product')]
    public function setProduct($product_id)
    {
        $this->form->reset();
        $product = Product::find($product_id);
        if($product){
            $user = User::find(Auth::user()->id);
            if($user->belongsToMe($product, 'products'))
                $this->form->setProduct($product);
        }
    }

    public function render()
    {
        return view('livewire.products.product-edit', [
            'vatRates' => VatRate::all()
        ]);
    }

    public function save()
    {
        $this->form->update();
        $this->dispatch('close');
        $this->dispatch('product-edited');
    }

    public function destroy()
    {
        $this->form->product?->delete();
        $this->dispatch('close');
        $this->dispatch('product-deleted');
    }
}
