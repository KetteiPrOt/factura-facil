<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;
use App\Livewire\Products\ProductIndex;

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
