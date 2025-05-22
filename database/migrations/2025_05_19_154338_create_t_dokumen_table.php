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
      Schema::create('t_dokumen', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mahasiswa_id')->constrained('m_mahasiswa', 'id_mahasiswa');  // Merujuk ke kolom id_mahasiswa
    $table->string('nama_dokumen');  // Nama dokumen (contoh: "Laporan Magang.pdf")
    $table->string('path');  // Path/lokasi penyimpanan dokumen
    $table->timestamps();  // created_at dan updated_at
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_dokumen');
    }
};
