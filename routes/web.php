<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SilsilahController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [SilsilahController::class, 'index'])->name('silsilah.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route tambahan

});

require __DIR__ . '/auth.php';
Route::get('/silsilah', [SilsilahController::class, 'index'])->name('silsilah.index');
Route::post('/store', [SilsilahController::class, 'store'])->name('silsilah.store');
Route::post('/tambah-orang-tua/{id}', [SilsilahController::class, 'tambahOrangTua'])->name('silsilah.tambahOrangTua');
Route::post('/tambah-pasangan/{id}', [SilsilahController::class, 'tambahPasangan'])->name('silsilah.tambahPasangan');
Route::post('/tambah-anak/{id}', [SilsilahController::class, 'tambahAnak'])->name('silsilah.tambahAnak');
Route::put('/silsilah/{id}', [SilsilahController::class, 'update'])->name('silsilah.update');
Route::delete('/silsilah/{id}', [SilsilahController::class, 'destroy'])
    ->middleware('auth')
    ->name('silsilah.destroy');
