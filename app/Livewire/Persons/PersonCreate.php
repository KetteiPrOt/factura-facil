<?php

namespace App\Livewire\Persons;

use App\Livewire\Forms\Persons\StoreForm;
use App\Models\Persons\IdentificationType;
use Livewire\Component;

class PersonCreate extends Component
{
    public StoreForm $form;

    public function render()
    {
        return view('livewire.persons.person-create', [
            'identificationTypes' => IdentificationType::where(
                'id', '!=', IdentificationType::finalConsumer()->id
            )->get()
        ]);
    }

    public function save()
    {
        $this->form->store();
        $this->form->reset();
        $this->dispatch('close');
        $this->dispatch('person-created');
    }
}
