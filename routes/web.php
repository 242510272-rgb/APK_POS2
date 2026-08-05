<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route untuk guest (belum login)
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

// Route yang bisa diakses ketika user sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route KHUSUS ADMIN (Kasir tidak bisa akses)
    Route::middleware('role:admin')->group(function () {
        // Management Users
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
            Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });

        // Management Jenis Produk (Dipindahkan ke sini agar Kasir terblokir)
        Route::resource('/jenis', JenisController::class);
    });

    // Route untuk ADMIN dan KASIR
    Route::middleware('role:admin,kasir')->group(function () {
        // Resource routes
        Route::resource('/produk', ProdukController::class);
        Route::resource('/penjualan', PenjualanController::class);
        Route::resource('/itempenjualan', ItemPenjualanController::class);

        // Route tambahan untuk penjualan
        Route::post('/penjualan/{penjualan}/checkout', [PenjualanController::class, 'checkout'])->name('penjualan.checkout');
        Route::delete('/penjualan/{penjualan}/cancel', [PenjualanController::class, 'cancel'])->name('penjualan.cancel');
    });
});