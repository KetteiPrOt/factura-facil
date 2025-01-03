<?php

namespace App\Livewire\Forms\Products;

use App\Models\Products\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class StoreForm extends Form
{
    use Rules;

    public function store()
    {
        $this->operation = 'store';
        $this->validate();
        $data = $this->all();
        $data['user_id'] = Auth::user()->id;
        Product::create($data);
    }
}
