<?php

use App\Http\Controllers\API\V1\PenggunaController;
use App\Http\Controllers\API\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\JenisPenggunaController;
use App\Http\Controllers\API\V1\ProdukController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/pengguna', PenggunaController::class);
        Route::patch('/pengguna/{pengguna}/jenis', JenisPenggunaController::class);
    });
    Route::apiResource('produk', ProdukController::class);
    
    // Route::controller(AuthController::class)->group(function () {
    //     Route::post('/logout', 'logout');
    //     Route::post('register', 'register');
    //     Route::post('login', 'login')->middleware('auth:sanctum');
    // });

    // // Route::get('/pengguna', function (Request $request) {
    // //     return $request->user();
    // // })->middleware('auth:sanctum');
});
