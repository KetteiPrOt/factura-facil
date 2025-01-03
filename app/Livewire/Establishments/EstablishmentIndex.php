<?php

namespace App\Livewire\Establishments;

use App\Models\Establishments\Establishment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class EstablishmentIndex extends Component
{
    use WithPagination;

    public $search;

    #[Title('Tus Establecimientos')]
    public function render()
    {
        return view('livewire.establishments.establishment-index', [
            'establishments' => $this->query()
        ]);
    }

    private function query()
    {
        $user = Auth::user();
        return Establishment::where('commercial_name', 'LIKE', '%'.$this->search.'%')
            ->where('user_id', $user->id)
            ->orderBy('commercial_name')
            ->paginate(15, pageName: 'establishments_page');
    }
}
