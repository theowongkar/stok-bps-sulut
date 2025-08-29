<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EmployeeController as DashboardEmployeeController;
use App\Http\Controllers\Dashboard\ItemController as DashboardItemController;

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
});
