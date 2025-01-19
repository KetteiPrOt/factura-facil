<?php

namespace App\Livewire\Receipts\Invoices;

use App\Livewire\Forms\Invoices\IndexForm;
use App\Models\Receipts\Receipt;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceIndex extends Component
{
    use WithPagination;

    public IndexForm $form;

    #[Locked]
    public $query_date_from;
    #[Locked]
    public $query_date_to;
    #[Locked]
    public $query_number;
    #[Locked]
    public $query_status;

    #[Title('Tus Facturas')]
    public function render()
    {
        return view('livewire.receipts.invoices.invoice-index', [
            'receipts' => $this->query()
        ]);
    }

    public function applyFilters()
    {
        $this->form->validate();
        $this->query_date_from = $this->form->date_from;
        $this->query_date_to = $this->form->date_to;
        $this->query_number = $this->form->number;
        $this->query_status = $this->form->status;
    }

    private function query()
    {
        $query = Receipt::orderBy('issuance_date');
        if($this->query_date_from)
            $query = $query->where('issuance_date', '>=', $this->query_date_from);
        if($this->query_date_to)
            $query = $query->where('issuance_date', '<=', $this->query_date_to);
        if($this->query_number)
            $query = $query->where('number', 'LIKE', '%'.$this->query_number.'%');
        if($this->query_status){
            $status = match($this->query_status){
                'issued' => 'Emitida.',
                'no-issued' => 'No emitida.',
                'authorized' => 'Autorizada.',
                'no-authorized' => 'No autorizada.',
            };
            $query = $query->where('status', $status);
        }
        return $query->paginate(15, pageName: 'receipts_page');
    }
}
