<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Define the web routes for the application
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard.kasir.index');
    }
    return redirect()->route('login');
})->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login-process');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('dashboard.kasir.index');
        });
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
});
