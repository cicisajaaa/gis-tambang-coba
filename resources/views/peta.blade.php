@extends('layouts.dashboard')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Elemen Peta Clean Slate */
    #map { 
        height: 540px; 
        border-radius: 12px; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        border: 1px solid #e3e6f0;
        z-index: 1;
    }
    
    /* Popup Leaflet Minimalis */
    .leaflet-popup-content-wrapper {
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
        padding: 2px;
    }

    /* Gaya Kartu Modul */
    .card-custom {
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        background: #ffffff;
    }
    
    /* Code Box GeoJSON */
    .code-box {
        background-color: #1a1c1e;
        color: #dee2e6;
        padding: 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        border-left: 3px solid #0d6efd;
        max-height: 135px;
        overflow-y: auto;
    }

    /* Gaya Input & Select Dropdown */
    .form-control-custom {
        border-radius: 8px;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        font-size: 0.88rem;
        background-color: #ffffff;
        transition: border-color 0.15s ease-in-out;
    }
    .form-control-custom:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.08);
        outline: none;
    }

    /* Tombol Utama Lebih Eye-Catching */
    .btn-action {
        background-color: #1a1c1e;
        color: #ffffff;
        font-weight: 500;
        font-size: 0.88rem;
        border-radius: 8px;
        padding: 9px 12px;
        border: 1px solid #1a1c1e;
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #ffffff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-3">
    <div class="mb-4 pb-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">Peta Validasi Wilayah Lahan</h4>
            <p class="text-muted small mb-0">Uji spasial tumpang tindih berkas GeoJSON terhadap basis data konsesi wilayah tambang.</p>
        </div>
        
        <form action="{{ route('peta.index') }}" method="GET" id="filterForm" class="d-flex align-items-center gap-2">
            <span class="small fw-medium text-secondary text-nowrap"><i class="fa-solid fa-filter me-1"></i> Saring Wilayah:</span>
            <select name="get_kabupaten" id="kabupatenSelect" class="form-select form-control-custom shadow-sm" style="min-width: 190px;" onchange="this.form.submit()">
                <option value="">Semua Kabupaten</option>
                @foreach($daftarKabupaten as $kab)
                    <option value="{{ $kab }}" {{ request('get_kabupaten') == $kab ? 'selected' : '' }}>{{ $kab }}</option>
                @endforeach
            </select>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show p-3 rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-5 me-3 text-success"></i>
                <div class="small">
                    <strong class="text-success d-block mb-1">Validasi Berhasil</strong>
                    <span class="text-secondary">{!! session('success') !!}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show p-3 rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-triangle-exclamation fs-5 me-3 text-danger"></i>
                <div class="small">
                    <strong class="text-danger d-block mb-1">Validasi Ditolak</strong>
                    <span class="text-secondary">{!! session('error') !!}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-custom shadow-sm p-4 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-light text-secondary p-2 rounded-3 me-2 border border-light-subtle">
                        <i class="fa-solid fa-file-arrow-up"></i>
                    </div>
                    <h6 class="fw-bold text-dark m-0">Simulasi Pengajuan Lahan</h6>
                </div>
                <p class="small text-muted mb-3">Pilih berkas spasial berformat <strong>.geojson</strong> untuk memproses batas tumpang tindih area.</p>
                
                <form action="{{ route('cek.wilayah') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" class="form-control form-control-custom" name="file_geojson" accept=".json,.geojson" required>
                    </div>
                    <button type="submit" class="btn btn-action w-100 mb-2">
                        <i class="fa-solid fa-magnifying-glass-location me-1"></i> Uji Kelayakan Batas
                    </button>
                </form>

                <hr class="text-muted my-3 opacity-25">
                
                <h6 class="fw-bold text-secondary small mb-2"><i class="fa-solid fa-circle-info me-1"></i>Sampel Struktur Koordinat:</h6>
                <p class="small text-muted mb-2">Simpan struktur teks di bawah ini menjadi file <code>uji.geojson</code> untuk pengujian wilayah aman:</p>
                
                <pre class="code-box font-monospace text-break mb-0" style="user-select: all;" title="Klik 3x untuk memblok seluruh kode">
{
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "geometry": {
        "type": "Polygon",
        "coordinates": [[
          [114.60, -3.10],
          [114.70, -3.10],
          [114.70, -3.20],
          [114.60, -3.20],
          [114.60, -3.10]
        ]]
      }
    }
  ]
}</pre>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-custom shadow-sm p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-light text-secondary p-2 rounded-3 me-2 border border-light-subtle">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <h6 class="fw-bold text-dark m-0">Visualisasi Peta Konsesi Tambang</h6>
                    </div>
                    <span class="badge bg-light text-secondary border px-2.5 py-1.5 rounded-pill font-monospace small" style="font-weight: 500;">
                        Layer Kontrol Aktif
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
    // 1. Definisikan Mode Peta
    var osmStreet = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    });

    var googleSatellite = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        attribution: '© Google Maps'
    });

    // 2. Inisialisasi Objek Peta
    var map = L.map('map', {
        zoomControl: true,
        fadeAnimation: true,
        layers: [osmStreet]
    }).setView([-3.44, 114.83], 9);

    var baseMaps = {
        "Peta Jalan (Standard)": osmStreet,
        "Citra Satelit (Satellite)": googleSatellite
    };

    L.control.layers(baseMaps, null, { position: 'topright' }).addTo(map);

    // 3. Logika Center Otomatis Berdasarkan Kabupaten Yang Dipilih (FlyTo)
    var pusatKabupaten = {
        'Tanah Laut': [-3.88, 114.82],
        'Tanah Bumbu': [-3.45, 115.70],
        'Kotabaru': [-3.00, 116.00],
        'Tapin': [-2.92, 115.03],
        'Banjar': [-3.32, 115.07],
        'Balangan': [-2.33, 115.62]
    };

    var kabTerpilih = "{{ request('get_kabupaten') }}";
    if (kabTerpilih && pusatKabupaten[kabTerpilih]) {
        map.flyTo(pusatKabupaten[kabTerpilih], 11, {
            animate: true,
            duration: 1.5
        });
    }

    // 4. Perulangan Menggambar Poligon Area dari Database
    @foreach($tambangAktif as $tambang)
        var wktText = "{{ $tambang->area }}";
        var cleanCoords = wktText.replace("POLYGON((", "").replace("))", "").split(",");
        var latLngs = cleanCoords.map(function(coord) {
            var parts = coord.trim().split(" ");
            return [parseFloat(parts[1]), parseFloat(parts[0])]; 
        });

        L.polygon(latLngs, {
            color: '#dc3545',
            fillColor: '#dc3545',
            fillOpacity: 0.14,
            weight: 1.5,
            dashArray: '4, 4'
        }).addTo(map).bindPopup(
            `<div style="font-family: sans-serif; padding: 2px; min-width: 180px;">
                <span class="text-danger fw-bold small d-block mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i>Konsesi Aktif</span>
                <div style="border-top: 1px solid #eee; margin-bottom: 6px;"></div>
                <table class="table table-borderless table-sm small mb-0" style="font-size: 0.78rem; line-height: 1.4;">
                    <tr><td class="text-muted p-0" style="width: 75px;">Perusahaan:</td><td class="fw-bold p-0 text-dark">${"{{ $tambang->nama_perusahaan }}"}</td></tr>
                    <tr><td class="text-muted p-0">No. IUP:</td><td class="font-monospace text-secondary p-0">${"{{ $tambang->nomor_iup }}"}</td></tr>
                    <tr><td class="text-muted p-0">Wilayah:</td><td class="text-dark p-0">${"{{ $tambang->kabupaten ?? 'Kalimantan Selatan' }}"}</td></tr>
                </table>
            </div>`
        );
    @endforeach
</script>
@endsection