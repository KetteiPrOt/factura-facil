<?php

namespace App\Http\Controllers\Receipts\Invoices;

use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Receipts\Invoices\XmlToObjectTree;
use App\Models\Receipts\PayMethod;
use App\Models\Receipts\Receipt;
use App\Models\User;

class PdfBuilder extends Controller
{
    public function build(Receipt $receipt, User $user)
    {
        if( ! $user->belongsToMe($receipt, 'receipts') )
            abort(403);

        $template = Storage::get('invoice_ride.html');
        $dompdf = new Dompdf();

        $xmlString = $this->clean($receipt->content);
        $invoice = XmlToObjectTree::fromXmlString($xmlString);

        $template = $this->loadUserData($receipt, $invoice, $template);
        $template = $this->loadClientData($receipt, $invoice, $template);
        $template = $this->loadDetails($invoice, $template);
        $template = $this->loadTotals($invoice, $template);
        // $template = $this->loadAdditionalInfo($invoice, $template);
        $template = $this->loadPaymethods($invoice, $template);

        // Load logo
        if($user->logo){
            $base64 = base64_encode(Storage::get("/logos/$user->logo"));
            $mimeType = Storage::mimeType("/logos/$user->logo");
            $data = 'data:' . $mimeType . ';base64,' . $base64;
            $logo = "<img class=\"logo\" src=\"$data\" />";
            $template = str_replace('{{logo}}', $logo, $template);
        } else {
            $template = str_replace('{{logo}}', '<p class="no-logo">No tiene logo</p>', $template);
        }
        // Render PDF
        $dompdf->loadHtml($template);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf;
    }

    private function clean(string $dirty): string
    {
        $start = mb_strlen("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
        $dirty = mb_substr($dirty, $start);
        $end = mb_strpos($dirty, '</detalles>') + 11;
        $cleaned = mb_substr($dirty, 0, $end) . '</factura>';
        return $cleaned;
    }

    private function loadUserData($receipt, $invoice, $template)
    {
        $template = str_replace('{{user_name}}', 
            $invoice->infoTributaria->razonSocial->value, $template);
        $template = str_replace('{{matrix_address}}', 
            $invoice->infoTributaria->dirMatriz->value, $template);
        $template = str_replace('{{establishment_address}}', 
            $invoice->infoFactura->dirEstablecimiento->value, $template);
        $template = str_replace('{{user_ruc}}', 
            $invoice->infoTributaria->ruc->value, $template);
        $template = str_replace('{{receipt_sequential}}', 
            $invoice->infoTributaria->estab->value . '-'
            . $invoice->infoTributaria->ptoEmi->value . '-'
            . $invoice->infoTributaria->secuencial->value, $template);
        $template = str_replace('{{access_key}}', 
            $invoice->infoTributaria->claveAcceso->value, $template);
        $template = str_replace('{{authorization_datetime}}', 
            date('d/m/Y H:i:s', strtotime($receipt->created_at)), $template);
        $template = str_replace('{{enviroment}}', 
            $invoice->infoTributaria->ambiente->value == '1'
            ? 'PRUEBAS' : 'PRODUCCIÓN', $template);
        
        return $template;
    }

    private function loadClientData($receipt, $invoice, $template)
    {
        $template = str_replace('{{social_reason}}', 
            $invoice->infoFactura->razonSocialComprador->value, $template);
        $template = str_replace('{{identification}}', 
            $invoice->infoFactura->identificacionComprador->value, $template);
        $template = str_replace('{{issuance_date}}', 
            $invoice->infoFactura->fechaEmision->value, $template);
        $template = str_replace('{{client_address}}',
            $receipt->client?->address ?? 'Ninguna.', $template);
        return $template;
    }

    private function loadDetails($invoice, $template)
    {
        $result = '';
        foreach($invoice->detalles->children as $detail){
            $result .= <<<HTML
                <tr>
                    <td>{$detail->codigoPrincipal->value}</td>
                    <td></td>
                    <td>{$detail->cantidad->value}</td>
                    <td>{$detail->descripcion->value}</td>
                    <td></td>
                    <td>{$detail->precioUnitario->value}</td>
                    <td>{$detail->descuento->value}</td>
                    <td>{$detail->precioTotalSinImpuesto->value}</td>
                </tr>
            HTML;
        }
        return str_replace('{{details}}', $result, $template);
    }

    private function loadTotals($invoice, $template)
    {
        $taxTotals = $invoice->infoFactura->totalConImpuestos->children;
        $template = str_replace('{{subtotal_15}}', 
            $this->extractValue($taxTotals, 1), $template);
        $template = str_replace('{{subtotal_0}}', 
            $this->extractValue($taxTotals, 0), $template);
        $template = str_replace('{{subtotal_no_vat}}', 
            $this->extractValue($taxTotals, 3), $template);
        $template = str_replace('{{subtotal_vat_exempt}}', 
            $this->extractValue($taxTotals, 4), $template);
        $template = str_replace('{{subtotal_without_tax}}', 
            $invoice->infoFactura->totalSinImpuestos->value, $template);
        $template = str_replace('{{total_discount}}', 
            $invoice->infoFactura->totalDescuento->value, $template);
        $template = str_replace('{{vat_15}}', 
            isset($taxTotals[1]) ? $taxTotals[1]->valor->value : '0.00', $template);
        $template = str_replace('{{total}}', 
            $invoice->infoFactura->importeTotal->value, $template);
        return $template;
    }

    private function extractValue($childrens, $key)
    {
        return isset($childrens[$key]) ? $childrens[$key]->baseImponible->value : '0.00';
    }

    // private function loadAdditionalInfo($invoice, $template)
    // {
    //     // TODO
    // }

    private function loadPaymethods($invoice, $template)
    {
        $payMethod = PayMethod::where(
            'code', $invoice->infoFactura->pagos->pago->formaPago->value
        )->first();
        $value = $invoice->infoFactura->pagos->pago->total->value;
        $template = str_replace('{{pay_method}}', $payMethod->name, $template);
        $template = str_replace('{{pay_value}}', $value, $template);
        return $template;
    }
}
