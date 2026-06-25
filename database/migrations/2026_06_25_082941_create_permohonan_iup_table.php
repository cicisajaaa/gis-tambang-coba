<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('permohonan_iup', function (Blueprint $table) {
        $table->id();
        $table->string('nama_perusahaan');
        $table->string('nomor_iup');
        $table->string('status'); // 'LOLOS' atau 'DITOLAK'
        $table->string('keterangan')->nullable();
        $table->timestamps(); // Ini akan mencatat bulan & tanggal pengajuan otomatis
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_iup');
    }
};
