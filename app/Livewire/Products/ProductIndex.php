<?php

namespace App\Livewire\Products;

use App\Models\Products\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;

    public $search;

    #[Title('Tus Productos')]
    public function render()
    {
        return view('livewire.products.product-index', [
            'products' => $this->query()
        ]);
    }

    public function query()
    {
        $user = Auth::user();
        return Product::where('name', 'LIKE', '%'.$this->search.'%')
            ->where('user_id', $user->id)
            ->orderBy('name')
            ->paginate(15, pageName: 'products_page');
    }
}
