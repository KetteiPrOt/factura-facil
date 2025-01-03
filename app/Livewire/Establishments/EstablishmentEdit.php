<?php

namespace App\Livewire\Establishments;

use App\Livewire\Forms\Establishments\UpdateForm;
use App\Models\Establishments\Establishment;
use Livewire\Component;

class EstablishmentEdit extends Component
{
    public UpdateForm $form;

    public function mount(Establishment $establishment)
    {
        $this->form->setEstablishment($establishment);
    }

    public function render()
    {
        return view('livewire.establishments.establishment-edit');
    }

    public function save()
    {
        $this->form->update();
        $this->dispatch('close');
        $this->dispatch('establishment-edited');
    }
}
