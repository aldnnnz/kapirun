<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\PenggunaController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\JenisPenggunaController;
use App\Http\Controllers\API\V1\ProdukController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::prefix('v1')->group(function () {
//     Route::controller(AuthController::class)->group(function () {
//         Route::post('login', 'login');
//         Route::post('register', 'register');
//     });
//     Route::middleware('auth:sanctum')->group(function () {
//         Route::apiResource('/pengguna', PenggunaController::class);
//         Route::patch('/pengguna/{pengguna}/jenis', JenisPenggunaController::class);
//     });
//     Route::apiResource('produk', ProdukController::class);


    Route::prefix('v1')->group(function () {
        // Auth Routes
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        
        // Protected Routes
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
            
            // Produk Routes
            // Route::apiResource('produk', ProdukController::class);
            // Route::post('produk/{id}/update-stok', [ProdukController::class, 'updateStok']);
            
            // // Admin only routes
            // Route::middleware(['role:admin'])->group(function () {
            //     Route::apiResource('pengguna', PenggunaController::class);
            //     Route::get('laporan/harian', [LaporanController::class, 'harian']);
            //     Route::get('laporan/bulanan', [LaporanController::class, 'bulanan']);
            //     Route::get('laporan/tahunan', [LaporanController::class, 'tahunan']);
            // });
            
            // Route::apiResource('kategori', KategoriController::class);
            // Route::apiResource('pelanggan', PelangganController::class);
            // Route::apiResource('transaksi', TransaksiController::class);
            // Route::get('riwayat-stok', [RiwayatStokController::class, 'index']);
        });
    });

