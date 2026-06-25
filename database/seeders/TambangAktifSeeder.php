<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TambangAktifSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh koordinat area berbentuk kotak di daerah Kalimantan Selatan
        // Format WKT (Well-Known Text): POLYGON((Long Lat, Long Lat, ...))
        // Catatan: Titik awal dan akhir harus sama (114.80 -3.40) untuk mengunci polygon
        $polygonWKT = "POLYGON((114.80 -3.40, 114.90 -3.40, 114.90 -3.50, 114.80 -3.50, 114.80 -3.40))";

        DB::table('tambang_aktif')->insert([
            'nama_perusahaan' => 'PT. Borneo Tambang Sejahtera',
            'nomor_iup' => 'IUP-2026-001',
            // ST_GeomFromText mengubah teks koordinat menjadi objek spasial di MySQL
            'koordinat_wilayah' => DB::raw("ST_GeomFromText('$polygonWKT')"),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}