<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermohonanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permohonan_iup')->insert([
            ['nama_perusahaan' => 'PT. Banua Bara Mandiri', 'nomor_iup' => 'IUP-2026-002', 'status' => 'LOLOS', 'keterangan' => 'Lahan Aman', 'created_at' => '2026-03-10 10:00:00'],
            ['nama_perusahaan' => 'PT. Kalsel Energi Tambang', 'nomor_iup' => 'IUP-2026-003', 'status' => 'DITOLAK', 'keterangan' => 'Menabrak PT. Borneo Tambang Sejahtera', 'created_at' => '2026-04-15 11:00:00'],
            ['nama_perusahaan' => 'PT. Meratus Jaya Abadi', 'nomor_iup' => 'IUP-2026-004', 'status' => 'LOLOS', 'keterangan' => 'Lahan Aman', 'created_at' => '2026-05-20 09:00:00'],
            ['nama_perusahaan' => 'PT. Tanah Laut Coal', 'nomor_iup' => 'IUP-2026-005', 'status' => 'DITOLAK', 'keterangan' => 'Menabrak Kawasan Hutan Lindung', 'created_at' => '2026-06-01 14:00:00'],
            ['nama_perusahaan' => 'PT. Amuntai Batubara', 'nomor_iup' => 'IUP-2026-006', 'status' => 'LOLOS', 'keterangan' => 'Lahan Aman', 'created_at' => '2026-06-25 15:30:00'],
        ]);
    }
}