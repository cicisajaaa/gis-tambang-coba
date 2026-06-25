@extends('layouts.dashboard')

@section('styles')
<style>
    .report-card {
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        background: #ffffff;
    }
    @media print {
        .btn-print, .sidebar { display: none !important; }
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
            <h3 class="fw-bold text-dark mb-1">Rekapitulasi Luas Wilayah Komoditas</h3>
            <p class="text-muted small mb-0">Akumulasi luas spasial kawasan tambang aktif berdasarkan jenis komoditas.</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm btn-print px-3">
            <i class="fa-solid fa-print me-2"></i>Cetak Laporan
        </button>
    </div>

    <!-- Tabel Rekap -->
    <div class="card report-card shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0 small">
                <thead class="table-light text-secondary text-uppercase font-monospace" style="font-size: 0.75rem;">
                    <tr>
                        <th class="py-3 px-3">Jenis Komoditas Pertambangan</th>
                        <th class="py-3 text-center" style="width: 220px;">Total IUP Terdaftar</th>
                        <th class="py-3 text-center" style="width: 260px;">Total Luas Wilayah Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekapLuas as $r)
                    <tr>
                        <td class="fw-bold text-dark py-3 px-3">
                            <i class="fa-solid fa-cubes text-secondary me-2"></i>{{ $r['komoditas'] }}
                        </td>
                        <td class="text-center text-secondary">{{ $r['jumlah_perusahaan'] }} Perusahaan</td>
                        <td class="text-center font-monospace fw-bold text-dark">
                            {{ number_format($r['luas']) }} Hektar
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection