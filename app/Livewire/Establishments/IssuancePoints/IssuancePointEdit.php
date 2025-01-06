<?php

namespace App\Livewire\Establishments\IssuancePoints;

use App\Livewire\Forms\Establishments\IssuancePoints\UpdateForm;
use App\Models\Establishments\Establishment;
use App\Models\Establishments\IssuancePoint;
use Livewire\Attributes\On;
use Livewire\Component;

class IssuancePointEdit extends Component
{
    public UpdateForm $form;

    #[On('load-issuance-point')]
    public function setIssuancePoint($issuance_point_id)
    {
        $this->form->resetExcept('establishment_id');
        $issuancePoint = IssuancePoint::find($issuance_point_id);
        if($issuancePoint){
            $establishment = Establishment::find($this->form->establishment_id);
            if($establishment->belongsToMe($issuancePoint, 'issuancePoints'))
                $this->form->setIssuancePoint($issuancePoint);
        }
    }

    public function mount(Establishment $establishment)
    {
        $this->form->establishment_id = $establishment->id;
    }

    public function render()
    {
        return view('livewire.establishments.issuance-points.issuance-point-edit');
    }

    public function save()
    {
        $this->form->update();
        $this->dispatch('close');
        $this->dispatch('issuance-point-edited');
    }

    public function destroy()
    {
        $this->form->issuancePoint->delete();
        $this->dispatch('close');
        $this->dispatch('issuance-point-deleted');
    }
}
