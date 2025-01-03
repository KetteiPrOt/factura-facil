<?php

namespace App\Livewire\Persons;

use App\Livewire\Forms\Persons\UpdateForm;
use App\Models\Persons\IdentificationType;
use App\Models\Persons\Person;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class PersonEdit extends Component
{
    public UpdateForm $form;

    #[On('load-person')]
    public function setPerson($person_id)
    {
        $this->form->reset();
        $person = Person::find($person_id);
        if($person){
            $user = User::find(Auth::user()->id);
            if($user->belongsToMe($person, 'persons'))
                $this->form->setPerson($person);
        }
    }

    public function render()
    {
        return view('livewire.persons.person-edit', [
            'identificationTypes' => IdentificationType::where(
                'id', '!=', IdentificationType::finalConsumer()->id
            )->get()
        ]);
    }

    public function save()
    {
        $this->form->update();
        $this->dispatch('close');
        $this->dispatch('person-edited');
    }

    public function destroy()
    {
        $this->form->person?->delete();
        $this->dispatch('close');
        $this->dispatch('person-deleted');
    }
}
