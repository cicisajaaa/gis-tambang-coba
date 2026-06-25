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
    Schema::create('tambang_aktif', function (Blueprint $table) {
        $table->id();
        $table->string('nama_perusahaan');
        $table->string('nomor_iup');
        
        // Di Laravel 11, gunakan geometry dengan parameter sub-tipe dan SRID opsional
        $table->geometry('koordinat_wilayah', subtype: 'polygon'); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tambang_aktif');
    }
};
