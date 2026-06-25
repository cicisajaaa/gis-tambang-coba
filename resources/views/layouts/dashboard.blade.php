<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SIG Pertambangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
    <style>
        body { 
            overflow-x: hidden; 
            background-color: #fdfdfd; 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
        }
        
        /* Sidebar Aesthetic Slate Modern */
        .sidebar { 
            min-height: 100vh; 
            width: 270px; 
            background-color: #131517; /* Warna hitam slate yang sangat elegan */
            transition: all 0.3s ease; 
            flex-shrink: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.03);
        }
        
        /* Identitas Brand */
        .brand-box {
            padding: 12px 8px;
        }
        .brand-logo-bg {
            background: rgba(13, 110, 253, 0.15);
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Desain Item Navigasi */
        .sidebar .nav-link { 
            color: #909499; /* Warna teks redup yang soft */
            padding: 11px 16px; 
            font-weight: 500; 
            font-size: 0.88rem;
            border-radius: 10px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }
        
        /* Efek Sorot (Hover) */
        .sidebar .nav-link:hover { 
            color: #ffffff; 
            background-color: rgba(255, 255, 255, 0.04);
            transform: translateX(3px); /* Efek geser tipis yang interaktif */
        }
        
        /* Keadaan Menu Aktif */
        .sidebar .nav-link.active { 
            color: #ffffff; 
            background-color: rgba(255, 255, 255, 0.08); /* Semi-transparan overlay netral */
            font-weight: 600;
            box-shadow: inset 3px 0 0 #0d6efd; /* Garis aksen biru vertikal di dalam tombol */
            border-radius: 10px;
        }
        .sidebar .nav-link.active:hover {
            transform: none;
        }

        /* Ikon Menu */
        .sidebar .nav-link i {
            font-size: 1.05rem;
            transition: color 0.2s;
        }
        .sidebar .nav-link.active i {
            color: #0d6efd; /* Ikon menyala biru hanya saat aktif */
        }

        /* Label Sub-Kategori Navigasi */
        .sidebar-section-title {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            color: rgba(255, 255, 255, 0.25);
            padding-left: 16px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        
        .content-area { flex: 1; padding: 28px; min-width: 0; }

        @media print {
            .sidebar { display: none !important; }
            .content-area { padding: 0 !important; width: 100% !important; }
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <div class="sidebar d-flex flex-column p-3 text-white">
            
            <div class="brand-box d-flex align-items-center mb-2">
                <div class="brand-logo-bg me-3">
                    <i class="fa-solid fa-map-location-dot fs-5 text-primary"></i>
                </div>
                <div>
                    <span class="fs-6 fw-bold tracking-tight d-block text-white">SIG-IUP</span>
                    <span class="text-muted d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">PROVINSI KALSEL</span>
                </div>
            </div>
            
            <ul class="nav nav-pills flex-column mb-auto">
                
                <div class="sidebar-section-title text-uppercase">Utama</div>
                <li>
                    <a href="{{ route('dashboard.utama') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie me-3" style="width: 18px;"></i> Dashboard Analisis
                    </a>
                </li>
                <li>
                    <a href="{{ route('peta.index') }}" class="nav-link {{ Request::is('peta') ? 'active' : '' }}">
                        <i class="fa-solid fa-map-marked-alt me-3" style="width: 18px;"></i> Peta Validasi Lahan
                    </a>
                </li>
                
                <div class="sidebar-section-title text-uppercase">Kompilasi Laporan</div>
                <li>
                    <a href="{{ route('laporan.tren') }}" class="nav-link {{ Request::is('laporan/tren') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-column me-3" style="width: 18px;"></i> Tren Pengajuan IUP
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.kelayakan') }}" class="nav-link {{ Request::is('laporan/kelayakan') ? 'active' : '' }}">
                        <i class="fa-solid fa-pie-chart me-3" style="width: 18px;"></i> Analisis Kelayakan Lahan
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.pelanggar') }}" class="nav-link {{ Request::is('laporan/pelanggar') ? 'active' : '' }}">
                        <i class="fa-solid fa-triangle-exclamation me-3" style="width: 18px;"></i> Rekapitulasi Pelanggar
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.luas') }}" class="nav-link {{ Request::is('laporan/luas') ? 'active' : '' }}">
                        <i class="fa-solid fa-mountain me-3" style="width: 18px;"></i> Distribusi Luas Wilayah
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.audit') }}" class="nav-link {{ Request::is('laporan/audit') ? 'active' : '' }}">
                        <i class="fa-solid fa-shield-halved me-3" style="width: 18px;"></i> Log Audit Keamanan
                    </a>
                </li>
            </ul>
            
            <div class="px-2 text-white-50 opacity-25" style="font-size: 0.72rem; letter-spacing: 0.3px;">
                Noor Shahla Q.R. © 2026
            </div>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>