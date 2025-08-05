<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'registerProcess'])->name('registerProcess');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('registerProcess');
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('index');
        Route::post('/', [KasirController::class, 'store'])->name('store');
    });

    Route::prefix('barang')->name('barang.')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::get('/create', [BarangController::class, 'create'])->name('create');
        Route::post('/store', [BarangController::class, 'store'])->name('store');
        Route::get('/edit/{barang}', [BarangController::class, 'edit'])->name('edit');
        Route::put('/update/{barang}', [BarangController::class, 'update'])->name('update');
        Route::delete('/delete/{barang}', [BarangController::class, 'delete'])->name('delete');
    });
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/show/{transaksi}', [TransaksiController::class, 'show'])->name('show');
        Route::delete('/delete/{transaksi}', [TransaksiController::class, 'delete'])->name('delete');
    });
});
