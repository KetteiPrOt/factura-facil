<?php

namespace App\Livewire\Establishments\IssuancePoints;

use App\Models\Establishments\Establishment;
use Livewire\Component;

class IssuancePointIndex extends Component
{
    public $search;
    
    public Establishment $establishment;

    public function render()
    {
        return view('livewire.establishments.issuance-points.issuance-point-index', [
            'issuancePoints' => $this->query()
        ]);
    }

    public function query()
    {
        return $this->establishment->issuancePoints()
            ->where('code', 'LIKE', '%' . $this->search . '%')
            ->orderBy('code')
            ->paginate(15, pageName: 'issuance_points_page');
    }
}
