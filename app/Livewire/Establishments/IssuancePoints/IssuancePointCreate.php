<?php

namespace App\Livewire\Establishments\IssuancePoints;

use App\Livewire\Forms\Establishments\IssuancePoints\StoreForm;
use App\Models\Establishments\Establishment;
use Livewire\Component;

class IssuancePointCreate extends Component
{
    public StoreForm $form;

    public function mount(Establishment $establishment)
    {
        $this->form->establishment_id = $establishment->id;
    }

    public function render()
    {
        return view('livewire.establishments.issuance-points.issuance-point-create');
    }
    
    public function save()
    {
        $this->form->store();
        $this->form->resetExcept('establishment_id');
        $this->dispatch('close');
        $this->dispatch('issuance-point-created');
    }
}
