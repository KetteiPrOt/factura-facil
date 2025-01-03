<?php

namespace App\Livewire\Forms\Persons;

use App\Models\Persons\Person;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class StoreForm extends Form
{
    use Rules;

    public function store()
    {
        $this->operation = 'store';
        $this->validate();
        $data = $this->all();
        $data['user_id'] = Auth::user()->id;
        return Person::create($data);
    }
}
