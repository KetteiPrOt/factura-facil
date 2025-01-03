<?php

namespace App\Livewire\Persons;

use App\Models\Persons\Person;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class PersonIndex extends Component
{
    use WithPagination;

    public $search;

    #[Title('Tus Clientes')]
    public function render()
    {
        return view('livewire.persons.person-index', [
            'persons' => $this->query()
        ]);
    }

    public function query()
    {
        $user = Auth::user();
        return Person::where('social_reason', 'LIKE', '%'.$this->search.'%')
            ->where('user_id', $user->id)
            ->orderBy('social_reason')
            ->paginate(15, pageName: 'persons_page');
    }
}
