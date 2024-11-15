<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
// use App\Http\Livewire\Pages;
// use App\Http\Livewire\Pages\Products;
// use App\Http\Livewire\Pages\Employees;
// use App\Http\Livewire\Pages\Pos;
use App\Http\Livewire\Components\Layout;
use Livewire\Livewire;
use App\Http\Livewire\Pages\Home;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::resource('produk', ProdukController::class);

Route::get('/', App\Livewire\Pages\Home::class)->name('pages.home');

Route::get('/produk', App\Livewire\Pages\Product::class)->name('pages.product');
