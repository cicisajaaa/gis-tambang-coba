@extends('layouts.dashboard')

@section('styles')
<style>
    .report-card {
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        background: #ffffff;
    }
    .chart-wrapper {
        position: relative;
        height: 360px;
        width: 100%;
    }
    @media print {
        .btn-print, .sidebar, hr { display: none !important; }
        .content-area { padding: 0 !important; width: 100% !important; }
        .report-card { border: none !important; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="mb-4 pb-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold text-dark mb-1">Laporan Tren Pengajuan IUP Bulanan</h3>
            <p class="text-muted small mb-0">Statistik berkas perizinan pertambangan yang masuk ke dalam sistem.</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm btn-print px-3">
            <i class="fa-solid fa-print me-2"></i>Cetak Laporan
        </button>
    </div>

    <!-- Konten Grafik -->
    <div class="card report-card p-4 shadow-sm mb-4">
        <div class="chart-wrapper">
            <canvas id="trenChart"></canvas>
        </div>
    </div>

    <!-- Catatan kaki/Analisis -->
    <div class="card report-card p-3 bg-light">
        <div class="d-flex align-items-start">
            <i class="fa-solid fa-circle-info text-primary mt-1 me-2"></i>
            <div class="small text-secondary">
                <strong class="text-dark">Catatan Sistem:</strong> Volume pengajuan izin usaha pertambangan terpantau stabil pada kuartal ini, dengan intensitas berkas masuk tertinggi tercatat pada bulan Juni.
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('trenChart'), {
        type: 'bar',
        data: {
            labels: ['Maret', 'April', 'Mei', 'Juni'],
            datasets: [{
                label: 'Jumlah Berkas Masuk',
                data: [1, 1, 1, 2],
                backgroundColor: '#0d6efd',
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endsection