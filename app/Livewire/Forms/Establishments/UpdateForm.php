<?php

namespace App\Livewire\Forms\Establishments;

use App\Models\Establishments\Establishment;
use Livewire\Form;

class UpdateForm extends Form
{
    use Rules;

    public ?Establishment $establishment;

    public function setEstablishment($establishment)
    {
        $this->establishment = $establishment;
        $this->fill([
            'code' => $establishment->code,
            'commercial_name' => $establishment->commercial_name,
            'address' => $establishment->address,
        ]);
    }

    public function update()
    {
        $this->operation = 'update';
        $this->validate();
        $this->establishment->update($this->all());
    }
}
