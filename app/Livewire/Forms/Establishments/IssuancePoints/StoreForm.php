<?php

namespace App\Livewire\Forms\Establishments\IssuancePoints;

use App\Models\Establishments\IssuancePoint;
use App\Models\Establishments\Sequential;
use App\Models\Receipts\ReceiptType;
use App\Livewire\Forms\Form;

class StoreForm extends Form
{
    use Rules;

    public function store()
    {
        $this->operation = 'store';
        $this->validate();
        $data = $this->all();
        $data['code'] = $this->numberToChar($data['code']);
        $issuancePoint = IssuancePoint::create($data);
        Sequential::create([
            'issuance_point_id' => $issuancePoint->id,
            'receipt_type_id' => ReceiptType::where('name', 'FACTURA')->first()->id
        ]);
    }
}
