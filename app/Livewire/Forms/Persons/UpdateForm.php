<?php

namespace App\Livewire\Forms\Persons;

use App\Models\Persons\Person;
use Livewire\Form;

class UpdateForm extends Form
{
    use Rules;

    public ?Person $person;

    public function setPerson($person)
    {
        $this->person = $person;
        $this->fill([
            'identification' => $person->identification,
            'social_reason' => $person->social_reason,
            'email' => $person->email,
            'phone_number' => $person->phone_number,
            'address' => $person->address,
            'identification_type_id' => $person->identification_type_id,
        ]);
    }

    public function update()
    {
        $this->operation = 'update';
        $this->validate();
        $this->person->update($this->all());
    }
}
