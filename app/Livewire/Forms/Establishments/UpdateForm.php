<?php

namespace App\Livewire\Forms\Establishments;

use App\Models\Establishments\Establishment;
use App\Livewire\Forms\Form;

class UpdateForm extends Form
{
    use Rules;

    public ?Establishment $establishment;

    public function setEstablishment($establishment)
    {
        $this->establishment = $establishment;
        $this->fill([
            'code' => intval($establishment->code),
            'commercial_name' => $establishment->commercial_name,
            'address' => $establishment->address,
        ]);
    }

    public function update()
    {
        $this->operation = 'update';
        $this->validate();
        $data = $this->all();
        $data['code'] = $this->numberToChar($data['code']);
        $this->establishment->update($data);
    }
}
