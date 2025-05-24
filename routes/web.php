<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\LaporanController;

// =======================
//         AUTH
// =======================

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =======================
//    PROTECTED ROUTES
// =======================

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.booking');

    // Pasien
    Route::prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/', [PasienController::class, 'index'])->name('index');
        Route::get('/create', [PasienController::class, 'create'])->name('create');
        Route::post('/', [PasienController::class, 'store'])->name('store');
        Route::get('/{id}', [PasienController::class, 'show'])->name('detail');
        Route::put('/{id}', [PasienController::class, 'update'])->name('update');
        Route::delete('/{id}', [PasienController::class, 'destroy'])->name('destroy');
    });

    // Rekam Medis (AJAX)
    Route::prefix('rekam-medis')->name('rekam.')->group(function () {
        Route::post('/{id_pasien}', [RekamMedisController::class, 'store'])->name('store');
        Route::put('/{id}', [RekamMedisController::class, 'update'])->name('update');
        Route::delete('/{id}', [RekamMedisController::class, 'destroy'])->name('destroy');
    });

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/export', [LaporanController::class, 'exportPdf'])->name('export');
    });
});
