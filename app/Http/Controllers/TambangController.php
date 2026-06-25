<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TambangController extends Controller
{
    /**
     * Menampilkan halaman utama (peta dan form upload).
     */
    public function dashboardUtama()
    {
        // Mengambil ringkasan data untuk ditampilkan di card widget dashboard utama
        $totalLolos = DB::table('permohonan_iup')->where('status', 'LOLOS')->count();
        $totalDitolak = DB::table('permohonan_iup')->where('status', 'DITOLAK')->count();

        return view('dashboard_utama', compact('totalLolos', 'totalDitolak'));
    }

    public function index(Request $request)
    {
        // 1. Tangkap input filter dari dropdown 'get_kabupaten' di blade peta
        $kabupatenDipilih = $request->get('get_kabupaten');

        // 2. Query dasar mengambil data seluruh tambang aktif dari database.
        // ST_AsText() digunakan untuk mengubah objek spasial di MySQL menjadi string teks biasa (WKT)
        $query = DB::table('tambang_aktif')
            ->select('nama_perusahaan', 'nomor_iup', 'kabupaten', DB::raw('ST_AsText(koordinat_wilayah) as area'));

        // 3. Jika user memilih kabupaten tertentu, filter query-nya
        if ($kabupatenDipilih) {
            $query->where('kabupaten', $kabupatenDipilih);
        }

        $tambangAktif = $query->get();

        // 4. Daftar kabupaten di Kalsel yang memegang area tambang untuk mengisi dropdown secara dinamis
        $daftarKabupaten = ['Tanah Laut', 'Tanah Bumbu', 'Kotabaru', 'Tapin', 'Banjar', 'Balangan'];

        return view('peta', compact('tambangAktif', 'daftarKabupaten'));
    }

    /**
     * Memproses file GeoJSON yang diunggah dan mendeteksi tumpang tindih lahan.
     */
    public function cekWilayah(Request $request)
    {
        // 1. Validasi berkas input wajib ada dan berformat file/text json
        $request->validate([
            'file_geojson' => 'required|file',
        ]);

        // 2. Membaca isi konten dari file GeoJSON yang diunggah
        $fileConten = file_get_contents($request->file('file_geojson')->getRealPath());
        $geoJson = json_decode($fileConten, true);

        if (!$geoJson || !isset($geoJson['features'][0]['geometry'])) {
            return back()->with('error', 'Format berkas GeoJSON tidak valid atau struktur geometry tidak ditemukan.');
        }

        // Ekstrak struktur koordinat polygon dari file yang diupload
        $geometry = $geoJson['features'][0]['geometry'];
        $coordinates = $geometry['coordinates'][0];

        // Konversi susunan array GeoJSON [[long, lat], ...] menjadi format String WKT 'POLYGON((long lat, long lat))'
        $wktPoints = [];
        foreach ($coordinates as $coord) {
            $wktPoints[] = $coord[0] . ' ' . $coord[1];
        }
        $wktString = "POLYGON((" . implode(',', $wktPoints) . "))";

        // 3. Ekstrak data opsional untuk nama perusahaan (jika ada di dalam properti berkas)
        $namaPerusahaanInput = $geoJson['features'][0]['properties']['perusahaan'] ?? 'PT. Simulasi Pemohon ' . rand(100, 999);
        $nomorIupOtomatis = 'IUP-' . date('Y') . '-' . rand(100, 999);

        // 4. Perbaikan Query Spasial MySQL (Menggunakan kolom 'koordinat_wilayah')
        $tumpangTindih = DB::table('tambang_aktif')
            ->whereRaw("ST_Intersects(ST_GeomFromText(?), koordinat_wilayah)", [$wktString])
            ->first();

        // 5. LOGIKA EVALUASI & PENYIMPANAN OTOMATIS KE TABEL LAPORAN
        if ($tumpangTindih) {
            $pesanError = "Gagal! Koordinat lahan menabrak wilayah aktif milik <b>" . $tumpangTindih->nama_perusahaan . "</b> (" . $tumpangTindih->nomor_iup . ").";
            
            // Simpan status GAGAL/DITOLAK ke tabel permohonan_iup untuk laporan
            DB::table('permohonan_iup')->insert([
                'nama_perusahaan' => $namaPerusahaanInput,
                'nomor_iup' => $nomorIupOtomatis,
                'status' => 'DITOLAK',
                'keterangan' => 'Tumpang tindih dengan ' . $tumpangTindih->nama_perusahaan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('error', $pesanError);
        } else {
            $pesanSukses = "Selamat! Wilayah yang diajukan <b>AMAN</b> dan bebas dari tumpang tindih lahan tambang lain.";
            
            // Simpan status LOLOS ke tabel permohonan_iup untuk laporan
            DB::table('permohonan_iup')->insert([
                'nama_perusahaan' => $namaPerusahaanInput,
                'nomor_iup' => $nomorIupOtomatis,
                'status' => 'LOLOS',
                'keterangan' => 'Lahan Bebas Konflik (Validitas Spasial Aman)',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', $pesanSukses);
        }
    }

    // 1. Laporan Tren Pengajuan Bulanan
    public function laporanTren() {
        return view('laporan.tren');
    }

    // 2. Laporan Kelayakan Lahan
    public function laporanKelayakan() {
        $totalLolos = DB::table('permohonan_iup')->where('status', 'LOLOS')->count();
        $totalDitolak = DB::table('permohonan_iup')->where('status', 'DITOLAK')->count();
        return view('laporan.kelayakan', compact('totalLolos', 'totalDitolak'));
    }

    // 3. Laporan Perusahaan Pelanggar
    public function laporanPelanggar() {
        $perusahaanKonflik = DB::table('permohonan_iup')->where('status', 'DITOLAK')->get();
        return view('laporan.pelanggar', compact('perusahaanKonflik'));
    }

    // 4. Laporan Rekapitulasi Luas Area
    public function laporanLuas() {
        $rekapLuas = [
            ['komoditas' => 'Batubara', 'luas' => 1500, 'jumlah_perusahaan' => 12],
            ['komoditas' => 'Bijih Besi', 'luas' => 450, 'jumlah_perusahaan' => 4],
            ['komoditas' => 'Emas/Batuan', 'luas' => 200, 'jumlah_perusahaan' => 2],
        ];
        return view('laporan.luas', compact('rekapLuas'));
    }

    // 5. Laporan Log Audit Keamanan
    public function laporanAudit() {
        $logAktivitas = [
            ['waktu' => '2026-06-25 14:20', 'user' => 'Petugas Admin', 'aksi' => 'Validasi berkas GeoJSON PT. Amuntai Batubara (Status: AMAN)'],
            ['waktu' => '2026-06-25 11:05', 'user' => 'Petugas Evaluator', 'aksi' => 'Sistem menolak otomatis file PT. Tanah Laut Coal (Status: KONFLIK)'],
        ];
        return view('laporan.audit', compact('logAktivitas'));
    }
}