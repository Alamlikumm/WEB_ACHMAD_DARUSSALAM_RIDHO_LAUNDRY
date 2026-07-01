<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// ===================== AUTH ROUTES =====================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===================== PROTECTED ROUTES =====================
Route::middleware(['auth'])->group(function () {

    // Dashboard - semua role bisa akses (level 1, 2, 3)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin only (level 1) - Master Data
    Route::middleware('checkLevel:1')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('customer', \App\Http\Controllers\Admin\CustomerController::class);
    Route::resource('service', \App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
});

    // Operator only (level 2) - Transaksi
    // Operator only (level 2) - Transaksi
Route::middleware('checkLevel:2')->prefix('operator')->name('operator.')->group(function () {
    Route::get('order', [\App\Http\Controllers\Operator\OrderController::class, 'index'])->name('order.index');
    Route::get('order/create', [\App\Http\Controllers\Operator\OrderController::class, 'create'])->name('order.create');
    Route::post('order', [\App\Http\Controllers\Operator\OrderController::class, 'store'])->name('order.store');
    Route::get('order/{order}', [\App\Http\Controllers\Operator\OrderController::class, 'show'])->name('order.show');
    Route::get('pickup', [\App\Http\Controllers\Operator\PickupController::class, 'index'])->name('pickup.index');
    Route::post('pickup/{order}/process', [\App\Http\Controllers\Operator\PickupController::class, 'process'])->name('pickup.process');
});

    // Pimpinan only (level 3) - Laporan
    // Pimpinan only (level 3) - Laporan
Route::middleware('checkLevel:3')->prefix('pimpinan')->name('pimpinan.')->group(function () {
    Route::get('report', [\App\Http\Controllers\Pimpinan\ReportController::class, 'index'])->name('report.index');
});
});
