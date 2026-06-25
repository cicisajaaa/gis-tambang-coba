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
            <h3 class="fw-bold text-dark mb-1">Daftar Perusahaan Pelanggar Batas Lahan</h3>
            <p class="text-muted small mb-0">Kompilasi dokumen permohonan yang ditolak otomatis karena terdeteksi tumpang tindih.</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm btn-print px-3">
            <i class="fa-solid fa-print me-2"></i>Cetak Laporan
        </button>
    </div>

    <!-- Tabel -->
    <div class="card report-card shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-dark" style="background-color: #212529;">
                    <tr>
                        <th class="py-3 px-3">Nama Perusahaan</th>
                        <th class="py-3 text-center" style="width: 160px;">Nomor IUP</th>
                        <th class="py-3 text-center" style="width: 140px;">Status</th>
                        <th class="py-3 px-3">Alasan Penolakan Sistem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perusahaanKonflik as $p)
                    <tr>
                        <td class="fw-bold text-dark py-3 px-3">{{ $p->nama_perusahaan }}</td>
                        <td class="text-center">
                            <span class="font-monospace text-secondary bg-light px-2 py-1 rounded border small">{{ $p->nomor_iup }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-1 px-2.5 py-1.5">{{ $p->status }}</span>
                        </td>
                        <td class="text-muted py-3 px-3">
                            <i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> {{ $p->keterangan }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5 bg-light">
                            <i class="fa-solid fa-folder-open fs-3 d-block mb-2 opacity-50"></i>
                            Belum ada rekam data penolakan berkas dalam database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection