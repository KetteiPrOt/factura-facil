<?php

namespace App\Livewire\Products;

use App\Models\Products\Product;
use Livewire\Component;

class Show extends Component
{
    public Product $product;

    public function render()
    {
        return view('livewire.products.show');
    }

    public function destroy()
    {
        $this->product->delete();
        return $this->redirectRoute('products.index');
    }
}
