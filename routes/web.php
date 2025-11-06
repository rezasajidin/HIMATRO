<?php

use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\KegiatanController; 
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\TemplateSuratController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Group untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    
    // Dashboard menampilkan daftar pengumuman
    Route::get('/dashboard', [PengumumanController::class, 'index'])->name('dashboard');

    // =========================
    // PENGUMUMAN CRUD
    // =========================
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

    // =========================
    // KEGIATAN
    // =========================
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::put('/kegiatan/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    // =========================
// TEMPLATE SURAT (Gunakan dalam SuratController saja)
// =========================
Route::get('/surat/template', [SuratController::class, 'template'])->name('surat.template');
Route::get('/surat/create/{id}', [SuratController::class, 'create'])->name('surat.create');
Route::post('/surat/generate/{id}', [SuratController::class, 'generate'])->name('surat.template.generate');

// =========================
// SURAT (Upload Biasa)
// =========================
Route::resource('surat', SuratController::class)->except(['show', 'create']);
Route::post('/surat/store', [SuratController::class, 'store'])->name('surat.store');

    // =========================
    // KEUANGAN
    // =========================
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');     
    Route::post('/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');   
    Route::put('/keuangan/{id}', [KeuanganController::class, 'update'])->name('keuangan.update'); 
    Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy'); 

    // =========================
    // AKUN
    // =========================
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy');

    // =========================
    // KEHADIRAN
    // =========================
    Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran.index');
    Route::post('/kehadiran/generate', [KehadiranController::class, 'generateQR'])->name('kehadiran.generate');
    Route::post('/kehadiran/scan', [KehadiranController::class, 'storeScan'])->name('kehadiran.store.scan');
});

require __DIR__ . '/auth.php';
