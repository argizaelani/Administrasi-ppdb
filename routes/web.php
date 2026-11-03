<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PendaftaranController;

// Perbaikan di bagian ini: Menggunakan redirect, bukan view
Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

// Arahkan halaman home setelah login ke daftar pendaftaran
Route::get('/home', [PendaftaranController::class, 'index'])->name('home');

// Route untuk CRUD Pendaftaran
Route::middleware(['auth'])->group(function () {
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // Tambahan route untuk Edit dan Hapus
    Route::get('/pendaftaran/{pendaftaran}/edit', [PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
    Route::put('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'update'])->name('pendaftaran.update');
    Route::delete('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

    // Route untuk fitur cetak
    Route::get('/pendaftaran/{pendaftaran}/cetak', [PendaftaranController::class, 'cetak'])->name('pendaftaran.cetak');
    Route::get('/pendaftaran/cetak-pdf', [PendaftaranController::class, 'cetakPdf'])->name('pendaftaran.cetak-pdf');
});