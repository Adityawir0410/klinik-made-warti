<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RekamMedisController;

// Halaman utama (opsional bisa redirect ke pasien)
Route::get('/', function () {
    return view('welcome');
});

// =======================
//        PASIEN
// =======================

// Daftar pasien
Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');

// Form tambah pasien (modal atau form terpisah)
Route::get('/pasien/create', [PasienController::class, 'create'])->name('pasien.create');

// Simpan data pasien
Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');

// Detail pasien + rekam medis
Route::get('/pasien/{id}', [PasienController::class, 'show'])->name('pasien.detail');

// Update data pasien
Route::put('/pasien/{id}', [PasienController::class, 'update'])->name('pasien.update');

// Hapus data pasien
Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');

// =============================
//     REKAM MEDIS (nested)
// =============================

// Simpan rekam medis baru untuk pasien tertentu (AJAX)
Route::post('/rekam-medis/{id_pasien}', [RekamMedisController::class, 'store'])->name('rekam.store');

// Update data rekam medis
Route::put('/rekam-medis/{id}', [RekamMedisController::class, 'update'])->name('rekam.update');

// Hapus data rekam medis
Route::delete('/rekam-medis/{id}', [RekamMedisController::class, 'destroy'])->name('rekam.destroy');
