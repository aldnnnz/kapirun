<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
// use App\Http\Livewire\Pages;
// use App\Http\Livewire\Pages\Products;
// use App\Http\Livewire\Pages\Employees;
// use App\Http\Livewire\Pages\Pos;
use App\Http\Livewire\Components\Layout;
use Livewire\Livewire;
use App\Http\Livewire\Pages\Home;
use App\Http\Middleware\EnsureAuthenticated;
use App\Livewire\Pages\Landing;
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::resource('produk', ProdukController::class);

    logger('Rute /login diakses');
    Route::get('/login', App\Livewire\Auth\Login::class)->name('auth.login');
    Route::get('/register', App\Livewire\Auth\Register::class)->name('auth.register');
// Route::middleware(EnsureAuthenticated::class)->group(function() {
//     Route::get('/', App\Livewire\Pages\Home::class)->name('pages.home');
// });
Route::middleware('auth')->group(function() {
    Route::get('/product', App\Livewire\Pages\Product::class)->name('pages.product');
    Route::get('/pos', App\Livewire\Pages\Home::class)->name('pages.home');
});
// Middleware untuk tamu (guest)

Route::get('/', function () {
    return view('livewire.pages.landing');
})->name('landing');