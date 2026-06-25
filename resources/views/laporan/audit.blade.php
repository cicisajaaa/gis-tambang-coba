@extends('layouts.dashboard')

@section('styles')
<style>
    .report-card {
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        background: #ffffff;
    }
    .log-row {
        border-bottom: 1px solid #f1f3f5;
    }
    .log-row:last-child {
        border-bottom: none;
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
            <h3 class="fw-bold text-dark mb-1">Log Audit Aktivitas Keamanan Sistem</h3>
            <p class="text-muted small mb-0">Kronologi pelacakan tindakan digital verifikator internal sistem perizinan.</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm btn-print px-3">
            <i class="fa-solid fa-print me-2"></i>Cetak Log Audit
        </button>
    </div>

    <!-- Log List -->
    <div class="card report-card shadow-sm p-2">
        <div class="card-body p-0">
            @foreach($logAktivitas as $log)
            <div class="log-row p-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <div>
                    <div class="fw-bold text-dark small mb-1">
                        <i class="fa-solid fa-user-check text-secondary me-2"></i>{{ $log['user'] }}
                    </div>
                    <span class="text-secondary small font-monospace d-block" style="font-size: 0.82rem;">{{ $log['aksi'] }}</span>
                </div>
                <span class="badge bg-light text-secondary border font-monospace px-2.5 py-1.5 rounded-1 small">
                    {{ $log['waktu'] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection