<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KasirCOntroller;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'registerProcess'])->name('registerProcess');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('registerProcess');
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('dashboard')->group(function () {
    Route::prefix('kasir')->group(function () {
        Route::get('/', [KasirCOntroller::class, 'index'])->name('index');
        Route::post('/', [KasirCOntroller::class, 'index'])->name('create');
        Route::put('/', [KasirCOntroller::class, 'index'])->name('edit');
        Route::delete('/', [KasirCOntroller::class, 'index'])->name('delete');
    });

    Route::prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::post('/', [BarangController::class, 'index'])->name('create');
        Route::put('/', [BarangController::class, 'index'])->name('edit');
        Route::delete('/', [BarangController::class, 'index'])->name('delete');
    });
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::post('/', [TransaksiController::class, 'index'])->name('create');
        Route::put('/', [TransaksiController::class, 'index'])->name('put');
        Route::delete('/', [TransaksiController::class, 'index'])->name('index');
    });
}); 