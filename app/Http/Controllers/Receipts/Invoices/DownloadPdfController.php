<?php

namespace App\Http\Controllers\Receipts\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Receipts\Receipt;
use Illuminate\Support\Facades\Auth;

class DownloadPdfController extends Controller
{
    public function __invoke(Receipt $receipt)
    {
        $builder = new PdfBuilder();
        return $builder->build($receipt, Auth::user())->stream('Factura.pdf');
    }
}
