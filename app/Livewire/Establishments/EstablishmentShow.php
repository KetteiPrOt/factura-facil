<?php

namespace App\Livewire\Establishments;

use App\Models\Establishments\Establishment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class EstablishmentShow extends Component
{
    public Establishment $establishment;

    public function mount(Establishment $establishment)
    {
        $user = User::find(Auth::user()->id);
        if($user->belongsToMe($establishment, 'establishments')){
            $this->establishment = $establishment;
        } else {
            $this->redirectRoute('establishments.index');
        }
    }

    #[Title('Ver Establecimiento')]
    public function render()
    {
        return view('livewire.establishments.establishment-show');
    }

    public function destroy()
    {
        $this->establishment->delete();
        $this->dispatch('close');
        $this->dispatch('establishment-deleted');
        return $this->redirectRoute('establishments.index');
    }
}
