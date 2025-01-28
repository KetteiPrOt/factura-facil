<?php

namespace App\Livewire\Receipts\Invoices\CreateInputs;

use App\Models\Establishments\Establishment;
use App\Models\Establishments\IssuancePoint;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class IssuancePointInput extends Component
{
    #[Modelable]
    public $value;

    #[Locked]
    public $establishment_id;

    #[On('establishment-changed')]
    public function setEstablishment($establishmentId)
    {
        $establishment = Establishment::find($establishmentId);
        if($establishment){
            $user = User::find(Auth::user()->id);
            if($user->belongsToMe($establishment, 'establishments')){
                $this->establishment_id = $establishmentId;
                $this->value = '';
            }
        }
    }

    public function render()
    {
        return view('livewire.receipts.invoices.create-inputs.issuance-point-input', [
            'issuancePoints' => IssuancePoint::where('establishment_id', $this->establishment_id)->get()
        ]);
    }
}
