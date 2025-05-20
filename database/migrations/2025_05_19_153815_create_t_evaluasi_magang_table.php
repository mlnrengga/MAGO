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
        Schema::create('t_evaluasi_magang', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mahasiswa_id')->constrained('m_mahasiswa', 'id_mahasiswa') ; // Merujuk ke kolom id_mahasiswa
    $table->foreignId('dospem_id')->constrained('m_dosen_pembimbing', 'id_dosen');  // Merujuk ke kolom id_dosen
    $table->integer('nilai')->nullable();  // Nilai evaluasi (boleh kosong)
    $table->text('catatan')->nullable();  // Catatan evaluasi (boleh kosong)
    $table->timestamps();  // created_at dan updated_at
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_evaluasi_magang');
    }
};
