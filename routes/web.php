<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;
use App\Livewire\Products\Index as ProductIndex;
use App\Livewire\Products\Show as ProductShow;
use App\Livewire\Products\Edit as ProductEdit;
use App\Livewire\Products\Create as ProductCreate;

Route::get('/', fn() => redirect()->route('login'));

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('/counter', Counter::class)->name('counter');

Route::middleware('auth')->get('/productos', ProductIndex::class)->name('products.index');
Route::middleware('auth')->get('/productos/crear', ProductCreate::class)->name('products.create');
Route::middleware('auth')->get('/productos/{product}', ProductShow::class)->name('products.show');
Route::middleware('auth')->get('/productos/{product}/editar', ProductEdit::class)->name('products.edit');
