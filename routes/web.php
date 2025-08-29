<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EmployeeController as DashboardEmployeeController;
use App\Http\Controllers\Dashboard\ItemController as DashboardItemController;
use App\Http\Controllers\Dashboard\StockInController as DashboardStockInController;
use App\Http\Controllers\Dashboard\StockOutController as DashboardStockOutController;

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:5,5')->name('authenticate');
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('throttle:5,5')->name('logout');

    // Default URL
    Route::get('/', fn() => redirect()->route('dashboard'));

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard Pegawai
    Route::get('/dashboard/pegawai', [DashboardEmployeeController::class, 'index'])->name('dashboard.employee.index');
    Route::post('/dashboard/pegawai/tambah', [DashboardEmployeeController::class, 'store'])->middleware('throttle:10,5')->name('dashboard.employee.store');
    Route::put('/dashboard/pegawai/{nip}/ubah', [DashboardEmployeeController::class, 'update'])->middleware('throttle:10,5')->name('dashboard.employee.update');
    Route::delete('/dashboard/pegawai/{nip}/hapus', [DashboardEmployeeController::class, 'destroy'])->middleware('throttle:10,5')->name('dashboard.employee.destroy');

    // Dashboard Data Barang
    Route::get('/dashboard/data-barang', [DashboardItemController::class, 'index'])->name('dashboard.item.index');
    Route::post('/dashboard/data-barang/tambah', [DashboardItemController::class, 'store'])->middleware('throttle:10,5')->name('dashboard.item.store');
    Route::put('/dashboard/data-barang/{sku}/ubah', [DashboardItemController::class, 'update'])->middleware('throttle:10,5')->name('dashboard.item.update');
    Route::delete('/dashboard/data-barang/{sku}/hapus', [DashboardItemController::class, 'destroy'])->middleware('throttle:10,5')->name('dashboard.item.destroy');

    // Dashboard Barang Masuk
    Route::get('/dashboard/barang-masuk', [DashboardStockInController::class, 'index'])->name('dashboard.stock-in.index');
    Route::post('/dashboard/barang-masuk/tambah', [DashboardStockInController::class, 'store'])->middleware('throttle:10,5')->name('dashboard.stock-in.store');
    Route::delete('/dashboard/barang-masuk/{id}/hapus', [DashboardStockInController::class, 'destroy'])->middleware('throttle:10,5')->name('dashboard.stock-in.destroy');

    // Dashboard Barang Keluar
    Route::get('/dashboard/barang-keluar', [DashboardStockOutController::class, 'index'])->name('dashboard.stock-out.index');
    Route::post('/dashboard/barang-keluar/tambah', [DashboardStockOutController::class, 'store'])->middleware('throttle:10,5')->name('dashboard.stock-out.store');
    Route::delete('/dashboard/barang-keluar/{id}/hapus', [DashboardStockOutController::class, 'destroy'])->middleware('throttle:10,5')->name('dashboard.stock-out.destroy');
});
