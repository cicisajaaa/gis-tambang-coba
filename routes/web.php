<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TambangController;

// Dashboard & Peta
Route::get('/', [TambangController::class, 'dashboardUtama'])->name('dashboard.utama');
Route::get('/peta', [TambangController::class, 'index'])->name('peta.index');
Route::post('/cek-wilayah', [TambangController::class, 'cekWilayah'])->name('cek.wilayah');

// Pecahan 5 Menu Laporan Berbeda
Route::get('/laporan/tren', [TambangController::class, 'laporanTren'])->name('laporan.tren');
Route::get('/laporan/kelayakan', [TambangController::class, 'laporanKelayakan'])->name('laporan.kelayakan');
Route::get('/laporan/pelanggar', [TambangController::class, 'laporanPelanggar'])->name('laporan.pelanggar');
Route::get('/laporan/luas', [TambangController::class, 'laporanLuas'])->name('laporan.luas');
Route::get('/laporan/audit', [TambangController::class, 'laporanAudit'])->name('laporan.audit');