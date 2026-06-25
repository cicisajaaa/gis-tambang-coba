@extends('layouts.dashboard')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Desain Elemen Peta */
    #map { 
        height: 550px; 
        border-radius: 16px; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
        z-index: 1; /* Menjaga agar dropdown bootstrap tidak tertutup peta */
    }
    
    /* Perbaikan Kustomisasi Popup Leaflet */
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        padding: 4px;
    }
    .leaflet-popup-tip {
        background: white;
    }

    /* Gaya Kartu Modul */
    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        background: #ffffff;
    }
    
    /* Modifikasi Box Code Snippet GeoJSON */
    .code-box {
        background-color: #1e1e24;
        color: #f8f9fa;
        padding: 14px;
        border-radius: 10px;
        font-size: 0.82rem;
        border-left: 4px solid #0d6efd;
        max-height: 160px;
        overflow-y: auto;
    }

    /* Gaya Input File Kustom */
    .form-control-custom {
        border-radius: 10px;
        padding: 10px 12px;
        border: 1.5px solid #dee2e6;
    }
    .form-control-custom:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-3">
    <div class="mb-4">
        <h2 class="fw-extrabold text-dark tracking-tight mb-1">Peta Validasi Wilayah Lahan</h2>
        <p class="text-muted">Lakukan pengujian tumpang tindih berkas spasial terhadap database konsesi tambang daerah.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show p-3 rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
                <div>
                    <strong class="text-success d-block">Sistem Valid: Aman</strong>
                    <span class="small">{!! session('success') !!}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show p-3 rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
                <div>
                    <strong class="text-danger d-block">Sistem Valid: Tumpang Tindih Terdeteksi</strong>
                    <span class="small">{!! session('error') !!}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-custom p-4 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                        <i class="fa-solid fa-file-arrow-up fs-5"></i>
                    </div>
                    <h5 class="fw-bold text-dark m-0">Simulasi Pengajuan Lahan</h5>
                </div>
                <p class="small text-muted mb-4">Unggah file spasial berformat <strong>.geojson</strong> atau <strong>.json</strong> untuk mendeteksi batas konflik area secara otomatis.</p>
                
                <form action="{{ route('cek.wilayah') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary mb-2">Pilih File Geospasial</label>
                        <input type="file" class="form-control form-control-custom shadow-sm" name="file_geojson" accept=".json,.geojson" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm py-2.5 rounded-3">
                        <i class="fa-solid fa-magnifying-glass-location me-2"></i>Uji Kelayakan Batas
                    </button>
                </form>

                <hr class="text-muted my-4">
                
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-circle-info text-secondary me-2"></i>
                    <h6 class="fw-bold text-secondary m-0">Petunjuk Uji Coba Lolos:</h6>
                </div>
                <p class="small text-muted mb-3">Salin kode struktur poligon di bawah ini ke dalam file teks baru bernama <code>uji_lahan.geojson</code> untuk mensimulasikan kondisi wilayah aman:</p>
                
                <pre class="code-box font-monospace text-break mb-0" style="user-select: all;" title="Klik 3x untuk memblok seluruh kode">
{
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [114.60, -3.10],
            [114.70, -3.10],
            [114.70, -3.20],
            [114.60, -3.20],
            [114.60, -3.10]
          ]
        ]
      }
    }
  ]
}</pre>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-custom p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success p-2 rounded-3 me-3">
                            <i class="fa-solid fa-earth-southeast fs-5"></i>
                        </div>
                        <h5 class="fw-bold text-dark m-0">Visualisasi Peta Konsesi Tambang</h5>
                    </div>
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small fw-medium">
                        <i class="fa-solid fa-location-crosshairs text-danger me-1"></i> Layer Control Active
                    </span>
                </div>
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // 1. Inisialisasi Pilihan Mode Basemap (Street vs Satellite)
    var osmStreet = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    });

    var googleSatellite = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        attribution: '© Google Maps'
    });

    // 2. Inisialisasi objek peta Leaflet (Berpusat di Kalimantan Selatan) dengan default mode OSM Street
    var map = L.map('map', {
        zoomControl: true,
        fadeAnimation: true,
        layers: [osmStreet] // Mode pertama kali dibuka
    }).setView([-3.44, 114.83], 10);

    // Bungkusan Layer untuk Menu Pilihan
    var baseMaps = {
        "Peta Jalan (Standard)": osmStreet,
        "Citra Satelit (Satellite)": googleSatellite
    };

    // Menambahkan Tombol Kontrol Pilihan Mode di Pojok Kanan Atas Peta
    L.control.layers(baseMaps, null, { position: 'topright' }).addTo(map);

    // 3. Mengambil data koordinat tambang aktif dari database via Blade Laravel
    @foreach($tambangAktif as $tambang)
        var wktText = "{{ $tambang->area }}";
        
        // Parsing string format 'POLYGON((long lat, long lat))' menjadi struktur array objek koordinat Leaflet
        var cleanCoords = wktText.replace("POLYGON((", "").replace("))", "").split(",");
        var latLngs = cleanCoords.map(function(coord) {
            var parts = coord.trim().split(" ");
            return [parseFloat(parts[1]), parseFloat(parts[0])]; 
        });

        // Menggambar area tambang terdaftar dengan warna merah semi transparan & border tegas
        L.polygon(latLngs, {
            color: '#e63946',
            fillColor: '#e63946',
            fillOpacity: 0.25,
            weight: 2.5,
            dashArray: '3, 5'
        }).addTo(map).bindPopup(
            `<div style="font-family: sans-serif; padding: 2px;">
                <h6 class="fw-bold text-danger my-1" style="font-size: 0.9rem;"><i class="fa-solid fa-triangle-exclamation me-1"></i>Wilayah Konsesi Aktif</h6>
                <hr class="my-1 text-muted">
                <table class="table table-borderless table-sm small mb-0" style="font-size: 0.8rem;">
                    <tr><td class="text-muted p-0 py-0.5">Perusahaan:</td><td class="fw-bold p-0 py-0.5 text-dark">${"{{ $tambang->nama_perusahaan }}"}</td></tr>
                    <tr><td class="text-muted p-0 py-0.5">No. IUP:</td><td class="font-monospace text-primary p-0 py-0.5">${"{{ $tambang->nomor_iup }}"}</td></tr>
                </table>
            </div>`
        );
    @endforeach
</script>
@endsection