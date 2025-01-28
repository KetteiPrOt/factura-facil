<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Establishments\EstablishmentIndex;
use App\Livewire\Establishments\EstablishmentShow;
use Illuminate\Support\Facades\Route;
use App\Livewire\Persons\PersonIndex;
use App\Livewire\Products\ProductIndex;
use App\Livewire\Receipts\Invoices\InvoiceCreate;
use App\Livewire\Receipts\Invoices\InvoiceIndex;
use App\Http\Controllers\Receipts\Invoices\DownloadPdfController as InvoiceDownloadController;

Route::get('/', fn() => redirect()->route('login'));

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware('auth')->get('/productos', ProductIndex::class)->name('products.index');
Route::middleware('auth')->get('/personas', PersonIndex::class)->name('persons.index');
Route::middleware('auth')->get('/establecimientos', EstablishmentIndex::class)->name('establishments.index');
Route::middleware('auth')->get('/establecimientos/{establishment}', EstablishmentShow::class)->name('establishments.show');
Route::middleware('auth')->get('/logo', [ProfileController::class, 'logo'])->name('profile.logo');
Route::middleware('auth')->get('/facturar', InvoiceCreate::class)->name('invoices.create');
Route::middleware('auth')->get('/comprobantes', InvoiceIndex::class)->name('invoices.index');
Route::middleware('auth')->get('/comprobantes/descargar/{receipt}', InvoiceDownloadController::class)->name('invoices.download');