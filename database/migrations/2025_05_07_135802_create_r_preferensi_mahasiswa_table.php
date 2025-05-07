<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('r_preferensi_mahasiswa', function (Blueprint $table) {
            $table->id('id_preferensi');
            $table->unsignedBigInteger('id_mahasiswa')->unique(); // hanya 1 preferensi per mahasiswa
        
            $table->unsignedBigInteger('id_bidang_keahlian');
            $table->unsignedTinyInteger('ranking_bidang'); // 1–3
        
            $table->unsignedBigInteger('id_lokasi_magang');
            $table->unsignedTinyInteger('ranking_lokasi'); // 1–3
        
            $table->unsignedBigInteger('id_jenis_magang');
            $table->unsignedTinyInteger('ranking_jenis'); // 1–3
            
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('m_mahasiswa');
            $table->foreign('id_bidang_keahlian')->references('id_bidang_keahlian')->on('m_bidang_keahlian');
            $table->foreign('id_lokasi_magang')->references('id_lokasi_magang')->on('m_lokasi_magang');
            $table->foreign('id_jenis_magang')->references('id_jenis_magang')->on('m_jenis_magang');

            DB::statement('ALTER TABLE r_preferensi_mahasiswa ADD CONSTRAINT ranking_bidang_check CHECK (ranking_bidang BETWEEN 1 AND 3)');
            DB::statement('ALTER TABLE r_preferensi_mahasiswa ADD CONSTRAINT ranking_lokasi_check CHECK (ranking_lokasi BETWEEN 1 AND 3)');
            DB::statement('ALTER TABLE r_preferensi_mahasiswa ADD CONSTRAINT ranking_jenis_check CHECK (ranking_jenis BETWEEN 1 AND 3)');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_preferensi_mahasiswa');
    }
};
