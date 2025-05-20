<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// =======================
//         LOGIN
// =======================

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =======================
//     PROTEKSI LOGIN
// =======================

Route::middleware(['auth'])->group(function () {

    // =======================
    //        DASHBOARD
    // =======================

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.booking');
    Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');


    // =======================
    //         LAPORAN
    // =======================

    Route::get('/laporan', function () {
        return view('laporan.index');
    })->name('laporan.index');

    // =======================
    //         PASIEN
    // =======================

    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
    Route::get('/pasien/create', [PasienController::class, 'create'])->name('pasien.create');
    Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');
    Route::get('/pasien/{id}', [PasienController::class, 'show'])->name('pasien.detail');
    Route::put('/pasien/{id}', [PasienController::class, 'update'])->name('pasien.update');
    Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');

    // =======================
    //     REKAM MEDIS (AJAX)
    // =======================

    Route::post('/rekam-medis/{id_pasien}', [RekamMedisController::class, 'store'])->name('rekam.store');
    Route::put('/rekam-medis/{id}', [RekamMedisController::class, 'update'])->name('rekam.update');
    Route::delete('/rekam-medis/{id}', [RekamMedisController::class, 'destroy'])->name('rekam.destroy');
});
