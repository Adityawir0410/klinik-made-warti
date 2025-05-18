<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController; // ✅ tambahkan baris ini
use App\Http\Controllers\RekamMedisController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');

// ⬇️ CREATE harus diletakkan sebelum SHOW
Route::get('/pasien/create', [PasienController::class, 'create'])->name('pasien.create');
Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');

// ⬇️ Baru show (karena {id} bisa nangkep apa aja)
Route::get('/pasien/{id}', [PasienController::class, 'show'])->name('pasien.detail');
Route::put('/pasien/{id}', [PasienController::class, 'update'])->name('pasien.update');
Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');

Route::post('/rekam-medis/{id_pasien}', [RekamMedisController::class, 'store'])->name('rekam.store');
Route::put('/rekam-medis/{id}', [RekamMedisController::class, 'update'])->name('rekam.update');
Route::delete('/rekam-medis/{id}', [RekamMedisController::class, 'destroy'])->name('rekam.destroy');