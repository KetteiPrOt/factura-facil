<?php

namespace App\Livewire\Receipts\Invoices\CreateInputs;

use App\Models\Establishments\Establishment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class EstablishmentInput extends Component
{
    #[Modelable]
    public $value;

    public function render()
    {
        return view('livewire.receipts.invoices.create-inputs.establishment-input', [
            'establishments' => Establishment::where('user_id', Auth::user()->id)->get()
        ]);
    }
}
