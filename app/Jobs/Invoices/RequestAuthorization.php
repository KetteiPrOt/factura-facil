<?php

namespace App\Jobs\Invoices;

use App\Mail\Receipts\Invoices\Mail as InvoiceMail;
use App\Models\Receipts\Receipt;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use SoapClient;

class RequestAuthorization implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Receipt $invoice
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $invoice = $this->invoice;
        try{
            $client = new SoapClient('https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl');
            $response = $client->autorizacionComprobante([
                'claveAccesoComprobante' => $invoice->access_key
            ]);
            $status = $this->extractStatus($response);
            if($status == 'AUTORIZADO'){
                $invoice->status = 'Autorizada.';
            } else if($status == 'NO AUTORIZADO') {
                $invoice->status = 'No autorizada.';
            } else if($status == 'EN PROCESAMIENTO') {
                $invoice->status = 'En procesamiento.';
            } else {
                $invoice->status = 'Sin respuesta.';
            }
        }catch(Exception $e){}
        $invoice->save();

        if($invoice->client_email)
            Mail::to($invoice->client_email)
                ->send(new InvoiceMail($invoice));
    }
    
    private function extractStatus($response)
    {
        if($response){
            if($response?->RespuestaAutorizacionComprobante){
                $response = $response->RespuestaAutorizacionComprobante;
                if($response?->autorizaciones){
                    $response = $response?->autorizaciones;
                    if($response?->autorizacion){
                        $response = $response?->autorizacion;
                        if($response?->estado){
                            $response = $response?->estado;
                            return $response;
                        }
                    }
                }
            }
        }
        return null;
    }
}
