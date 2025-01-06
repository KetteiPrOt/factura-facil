<?php

namespace App\Livewire\Forms\Establishments\IssuancePoints;

use App\Livewire\Forms\Form;
use App\Models\Establishments\IssuancePoint;

class UpdateForm extends Form
{
    use Rules;

    public ?IssuancePoint $issuancePoint;

    public function setIssuancePoint($issuancePoint)
    {
        $this->issuancePoint = $issuancePoint;
        $this->fill([
            'code' => intval($issuancePoint->code),
            'description' => $issuancePoint->description,
        ]);
    }

    public function update()
    {
        $this->operation = 'update';
        $this->validate();
        $data = $this->all();
        $data['code'] = $this->numberToChar($data['code']);
        $this->issuancePoint->update($data);
    }
}
