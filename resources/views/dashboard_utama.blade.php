@extends('layouts.dashboard')

@section('styles')
<style>
    /* Desain ringkas & profesional (Human-crafted style) */
    .stat-card {
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        background: #ffffff;
        transition: all 0.25s ease-in-out;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
    }
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Alur Kerja / Panduan */
    .workflow-item {
        position: relative;
        padding-left: 2.5rem;
    }
    .workflow-number {
        position: absolute;
        left: 0;
        top: 2px;
        width: 26px;
        height: 26px;
        background-color: #f1f3f5;
        color: #495057;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid #dee2e6;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="mb-4 pb-3 border-bottom">
        <h3 class="fw-bold text-dark mb-1">Dashboard Analisis Sistem</h3>
        <p class="text-muted small mb-0">Sistem Informasi Geografis Deteksi Tumpang Tindih Wilayah IUP Provinsi Kalimantan Selatan.</p>
    </div>

    <!-- Tiga Ringkasan Kartu Utama -->
    <div class="row g-3 mb-4">
        <!-- Total IUP Aktif -->
        <div class="col-md-4">
            <div class="card stat-card p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase tracking-wider d-block mb-1">Total IUP Aktif</span>
                        <h2 class="fw-bold text-dark mb-0">1</h2>
                    </div>
                    <div class="icon-box bg-light text-primary border">
                        <i class="fa-solid fa-mountain-city fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengajuan Lolos -->
        <div class="col-md-4">
            <div class="card stat-card p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase tracking-wider d-block mb-1">Pengajuan Lolos</span>
                        <h2 class="fw-bold text-success mb-0">{{ $totalLolos }}</h2>
                    </div>
                    <div class="icon-box bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                        <i class="fa-solid fa-circle-check fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengajuan Konflik -->
        <div class="col-md-4">
            <div class="card stat-card p-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase tracking-wider d-block mb-1">Pengajuan Konflik</span>
                        <h2 class="fw-bold text-danger mb-0">{{ $totalDitolak }}</h2>
                    </div>
                    <div class="icon-box bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                        <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panduan Pengoperasian Sistem -->
    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
        <h5 class="fw-bold text-dark mb-3">Panduan Pengoperasian Sistem</h5>
        <hr class="my-2 text-muted opacity-25">
        
        <div class="row g-4 mt-1">
            <div class="col-md-4">
                <div class="workflow-item">
                    <div class="workflow-number">1</div>
                    <h6 class="fw-bold text-dark mb-1">Validasi Dokumen Spasial</h6>
                    <p class="text-muted small mb-0">Masuk ke menu <span class="text-primary fw-medium">Peta Validasi Lahan</span> untuk melakukan uji klinis berkas GeoJSON baru yang diajukan.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="workflow-item">
                    <div class="workflow-number">2</div>
                    <h6 class="fw-bold text-dark mb-1">Pengecekan Intersects</h6>
                    <p class="text-muted small mb-0">Sistem melakukan kalkulasi spasial secara otomatis guna menguji ada tidaknya tumpang tindih batas koordinat.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="workflow-item">
                    <div class="workflow-number">3</div>
                    <h6 class="fw-bold text-dark mb-1">Rekapitulasi Data</h6>
                    <p class="text-muted small mb-0">Seluruh riwayat pengujian akan dikelompokkan secara mendalam pada lembar halaman <span class="text-primary fw-medium">Modul Laporan</span>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection