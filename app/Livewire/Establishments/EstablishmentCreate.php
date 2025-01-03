<?php

namespace App\Livewire\Establishments;

use App\Livewire\Forms\Establishments\StoreForm;
use Livewire\Component;

class EstablishmentCreate extends Component
{
    public StoreForm $form;

    public function render()
    {
        return view('livewire.establishments.establishment-create');
    }

    public function save()
    {
        $this->form->store();
        $this->form->reset();
        $this->dispatch('close');
        $this->dispatch('establishment-created');
    }
}
