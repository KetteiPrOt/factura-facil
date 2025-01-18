<?php

namespace App\Livewire\Receipts\Invoices\CreateInputs;

use App\Models\Persons\Person;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SearchClient extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        return view('livewire.receipts.invoices.create-inputs.search-client', [
            'persons' => $this->query()
        ]);
    }

    private function query()
    {
        $user = Auth::user();
        $query = Person::where('social_reason', 'LIKE', '%'.$this->search.'%')
            ->where('user_id', $user->id)
            ->orderBy('social_reason');
        if(is_null($this->search) || $this->search == '')
            $query = $query->where('id', 0);
        $persons = $query->paginate(3, pageName: 'persons_page');
        if($persons->isEmpty())
            $this->resetPage('persons_page');
        return $persons;
    }
}
