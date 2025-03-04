<?php

namespace App\Livewire\Forms\Establishments;

use App\Models\Establishments\Establishment;
use App\Models\Establishments\IssuancePoint;
use App\Models\Establishments\Sequential;
use App\Models\Receipts\ReceiptType;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\Form;

class StoreForm extends Form
{
    use Rules;

    public function store()
    {
        $this->operation = 'store';
        $this->validate();
        $data = $this->all();
        $data['user_id'] = Auth::user()->id;
        $data['code'] = $this->numberToChar($data['code']);
        $establishment = Establishment::create($data);
        $issuancePoint = IssuancePoint::create([
            'code' => '001',
            'establishment_id' => $establishment->id
        ]);
        Sequential::create([
            'issuance_point_id' => $issuancePoint->id,
            'receipt_type_id' => ReceiptType::where('name', 'FACTURA')->first()->id
        ]);
    }
}
