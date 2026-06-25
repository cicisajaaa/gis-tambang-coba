@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark m-0">📊 Pusat Laporan & Analisis Data Perizinan</h2>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card card-body shadow-sm border-0 p-4 bg-white">
                <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-chart-column me-2"></i>1. Laporan Tren Pengajuan Bulanan</h5>
                <div style="height: 250px;"><canvas id="trenChart"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body shadow-sm border-0 p-4 bg-white">
                <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-chart-pie me-2"></i>2. Laporan Persentase Kelayakan Lahan</h5>
                <div style="height: 250px; width: 250px;" class="mx-auto"><canvas id="statusChart"></canvas></div>
            </div>
        </div>
    </div>

    <div class="card card-body shadow-sm border-0 mb-4 p-4 bg-white">
        <h5 class="fw-bold text-danger mb-3"><i class="fa-solid fa-triangle-exclamation me-2"></i>3. Laporan Perusahaan Pelanggar Batas Lahan (Ditolak)</h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover small mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Perusahaan</th>
                        <th>Nomor IUP</th>
                        <th>Status</th>
                        <th>Catatan Kegagalan Sistem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($perusahaanKonflik as $p)
                    <tr>
                        <td class="fw-bold">{{ $p->nama_perusahaan }}</td>
                        <td>{{ $p->nomor_iup }}</td>
                        <td><span class="badge bg-danger">{{ $p->status }}</span></td>
                        <td class="text-muted">{{ $p->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-body shadow-sm border-0 mb-4 p-4 bg-white">
        <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-mountain me-2"></i>4. Laporan Rekapitulasi Luas Area Komoditas Tambang</h5>
        <div class="table-responsive">
            <table class="table table-bordered small mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Jenis Komoditas</th>
                        <th>Total Jumlah IUP Aktif</th>
                        <th>Total Luas Lahan Wilayah Terpetakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekapLuas as $r)
                    <tr>
                        <td class="fw-bold">{{ $r['komoditas'] }}</td>
                        <td>{{ $r['jumlah_perusahaan'] }} Perusahaan</td>
                        <td><strong>{{ $r['luas'] }} Hektar</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-body shadow-sm border-0 p-4 bg-white">
        <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-shield-halved me-2"></i>5. Laporan Log Audit Aktivitas Sistem (Keamanan Data)</h5>
        <ul class="list-group list-group-flush small">
            @foreach($logAktivitas as $log)
            <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                <div class="ms-2 me-auto">
                    <div class="fw-bold text-dark">{{ $log['user'] }}</div>
                    <span class="text-muted">{{ $log['aksi'] }}</span>
                </div>
                <span class="badge bg-secondary rounded-pill">{{ $log['waktu'] }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>ß
    new Chart(document.getElementById('trenChart'), {
        type: 'bar',
        data: {
            labels: ['Maret', 'April', 'Mei', 'Juni'],
            datasets: [{
                label: 'Jumlah Pengajuan Masuk',
                data: [1, 1, 1, 2],
                backgroundColor: '#0d6efd'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Grafik 2: Pie Chart Kelayakan Lahan
    new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: ['Lolos (Aman)', 'Ditolak (Konflik)'],
            datasets: [{
                data: [{{ $totalLolos }}, {{ $totalDitolak }}],
                backgroundColor: ['#198754', '#dc3545']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endsection