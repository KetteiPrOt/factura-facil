<?php

namespace App\Livewire\Products;

use App\Models\Products\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    #[Title('Tus Productos')]
    public function render()
    {
        return view('livewire.products.index', [
            'products' => $this->query()
        ]);
    }

    public function query()
    {
        $user = Auth::user();
        return Product::where('name', 'LIKE', '%'.$this->search.'%')
            ->where('user_id', $user->id)
            ->paginate(15, pageName: 'products_page');
    }
} 
