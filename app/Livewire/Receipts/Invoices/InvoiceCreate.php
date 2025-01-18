<?php

namespace App\Livewire\Receipts\Invoices;

use App\Livewire\Forms\Invoices\StoreForm;
use App\Models\Persons\Person;
use App\Models\Products\Product;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

class InvoiceCreate extends Component
{
    public StoreForm $form;

    /**
     * Keeps record about each product that has existed on the page
     */
    #[Locked]
    public int $products_key = 0;

    public function mount()
    {
        $this->form->issuance_date = date('Y-m-d');
    }

    #[Title('Facturar')]
    public function render()
    {
        return view('livewire.receipts.invoices.invoice-create', [
            'selected' => Arr::pluck($this->form->products, 'id')
        ]);
    }

    public function save()
    {
        $this->form->validate();
        $data = $this->form->all();
        dump($data);
        $this->form->reset();
        $this->dispatch('invoice-created');
    }

    public function removeProduct($key)
    {
        unset($this->form->products[$key]);
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);
        if($product){
            $user = User::find(Auth::user()->id);
            if($user->belongsToMe($product, 'products')){
                $this->form->products[$this->products_key] = ['id' => $product->id, 'discount' => 0, 'amount' => 1, 'price' => $product->price];
                $this->products_key++;
            }
        }
    }

    public function loadClient($personId)
    {
        $person = Person::find($personId);
        if($person){
            $user = User::find(Auth::user()->id);
            if($user->belongsToMe($person, 'persons')){
                $this->form->social_reason = $person->social_reason;
                $this->form->identification = $person->identification;
                $this->form->identification_type_id = $person->identification_type_id;
                $this->form->email = $person->email;
                $this->form->address = $person->address;
                $this->form->phone_number = $person->phone_number;
            }
        }
    }
}
