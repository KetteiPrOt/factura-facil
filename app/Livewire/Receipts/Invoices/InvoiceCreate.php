<?php

namespace App\Livewire\Receipts\Invoices;

use App\Jobs\Invoices\RequestAuthorization;
use App\Livewire\Forms\Invoices\StoreForm;
use App\Models\Persons\Person;
use App\Models\Products\Product;
use App\Models\Receipts\Receipt;
use App\Models\Receipts\ReceiptType;
use App\Models\User;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;
use SoapClient;

class InvoiceCreate extends Component
{
    public StoreForm $form;

    /**
     * Keeps record about each product that has existed on the page
     */
    #[Locked]
    public int $products_key = 0;

    public function mount()
    {
        $this->form->issuance_date = date('Y-m-d');
        if( ! Auth::user()->certificate->uploaded )
            $this->redirect('profile', navigate: true);
    }

    #[Title('Facturar')]
    public function render()
    {
        return view('livewire.receipts.invoices.invoice-create', [
            'selected' => Arr::pluck($this->form->products, 'id')
        ]);
    }

    public function save()
    {
        $this->form->validate();
        $validated = $this->form->all();
        $user = Auth::user();
        $builder = new Builder();
        $raw = $builder->build($validated, $user);
        $signer = new Signer();
        $signed = $signer->sign($raw, $user, config('app.openssl-cli', 'openssl'));

        $status = $this->issue($signed);

        $invoice = Receipt::create([
            'access_key' => $builder->access_key,
            'issuance_date' => $validated['issuance_date'],
            'number' => $builder->establishment->code
                . '-' . $builder->issuancePoint->code
                . '-' . $builder->sequential, // 001-001-000000001
            'status' => $status,
            'content' => $signed,
            'client_email' => $validated['email'] ?? null,
            'user_id' => $user->id,
            'receipt_type_id' => ReceiptType::where('name', 'FACTURA')->first()->id
        ]);

        RequestAuthorization::dispatch($invoice);

        $this->form->reset('products');
        $this->dispatch('invoice-created');
    }

    private function issue($signed)
    {
        try {
            $client = new SoapClient('https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl');
            $response = $client->validarComprobante(['xml' => $signed]);
        } catch(Exception $e) {
            $response = null;
        }

        $status = 'No emitida.';

        if(isset($response?->RespuestaRecepcionComprobante)){
            if(isset($response?->RespuestaRecepcionComprobante?->estado)){
                $status =
                    $response?->RespuestaRecepcionComprobante?->estado
                    == 'RECIBIDA'
                    ? 'Emitida.'
                    : 'No emitida.';
            }
        }

        return $status;
    }

    public function removeProduct($key)
    {
        unset($this->form->products[$key]);
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);
        if($product){
            $user = User::find(Auth::user()->id);
            if($user->belongsToMe($product, 'products')){
                $this->form->products[$this->products_key] = ['id' => $product->id, 'discount' => 0, 'amount' => 1, 'price' => $product->price];
                $this->products_key++;
            }
        }
    }

    public function loadClient($personId)
    {
        $person = Person::find($personId);
        if($person){
            $user = User::find(Auth::user()->id);
            if($user->belongsToMe($person, 'persons')){
                $this->form->social_reason = $person->social_reason;
                $this->form->identification = $person->identification;
                $this->form->identification_type_id = $person->identification_type_id;
                $this->form->email = $person->email;
                $this->form->address = $person->address;
                $this->form->phone_number = $person->phone_number;
            }
        }
    }
}
