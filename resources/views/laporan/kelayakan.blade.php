@extends('layouts.dashboard')

@section('styles')
<style>
    .report-card {
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        background: #ffffff;
    }
    .legend-indicator {
        width: 12px;
        height: 12px;
        border-radius: 3px;
        display: inline-block;
    }
    @media print {
        .btn-print, .sidebar { display: none !important; }
        .content-area { padding: 0 !important; width: 100% !important; }
        .row { display: block !important; }
        .col-md-5, .col-md-7 { width: 100% !important; display: block !important; margin-bottom: 25px; }
        canvas { max-width: 200px !important; max-height: 200px !important; margin: 0 auto !important; }
        .report-card { border: none !important; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-2">
    <!-- Header -->
    <div class="mb-4 pb-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold text-dark mb-1">Laporan Persentase Kelayakan Lahan</h3>
            <p class="text-muted small mb-0">Rasio perbandingan berkas yang lolos validasi spasial terhadap konflik batas wilayah.</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm btn-print px-3">
            <i class="fa-solid fa-print me-2"></i>Cetak Laporan
        </button>
    </div>

    <div class="card report-card p-4 shadow-sm">
        <div class="row align-items-center g-4">
            <!-- Diagram -->
            <div class="col-md-5 text-center">
                <div style="height: 240px; width: 240px;" class="mx-auto">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
            <!-- Tabel Data -->
            <div class="col-md-7">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0 small">
                        <thead class="table-light text-secondary text-uppercase font-monospace" style="font-size: 0.75rem;">
                            <tr>
                                <th>Kategori Hasil Pengecekan</th>
                                <th class="text-center" style="width: 120px;">Total Berkas</th>
                                <th class="text-center" style="width: 180px;">Tindakan Sistem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="legend-indicator bg-success me-2 align-middle"></span>
                                    <span class="fw-medium text-dark">Lolos (Bebas Konflik)</span>
                                </td>
                                <td class="text-center fw-bold text-success">{{ $totalLolos }}</td>
                                <td class="text-center"><span class="badge bg-light text-success border border-success border-opacity-25 rounded-1">Diteruskan ke Dinas</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="legend-indicator bg-danger me-2 align-middle"></span>
                                    <span class="fw-medium text-dark">Ditolak (Tumpang Tindih)</span>
                                </td>
                                <td class="text-center fw-bold text-danger">{{ $totalDitolak }}</td>
                                <td class="text-center"><span class="badge bg-light text-danger border border-danger border-opacity-25 rounded-1">Arsip / Batalkan</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: ['Lolos', 'Ditolak'],
            datasets: [{
                data: [{{ $totalLolos }}, {{ $totalDitolak }}],
                backgroundColor: ['#198754', '#dc3545'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection