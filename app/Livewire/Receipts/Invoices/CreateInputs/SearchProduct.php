<?php

namespace App\Livewire\Receipts\Invoices\CreateInputs;

use App\Models\Products\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithPagination;

class SearchProduct extends Component
{
    use WithPagination;

    #[Reactive]
    public $selected;

    public $search;

    public function render()
    {
        return view('livewire.receipts.invoices.create-inputs.search-product', [
            'products' => $this->query()
        ]);
    }

    private function query()
    {
        $user = Auth::user();
        $query = Product::where('name', 'LIKE', '%'.$this->search.'%')
            ->where('user_id', $user->id)
            ->whereNotIn('id', $this->selected)
            ->orderBy('name');
        if(is_null($this->search) || $this->search == '')
            $query = $query->where('id', 0);
        $products = $query->paginate(3, pageName: 'products_page');
        if($products->isEmpty())
            $this->resetPage('products_page');
        return $products;
    }
}
