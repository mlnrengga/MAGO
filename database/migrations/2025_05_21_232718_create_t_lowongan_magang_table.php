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
        Schema::create('t_lowongan_magang', function (Blueprint $table) {
            $table->id('id_lowongan');
            $table->unsignedBigInteger('id_jenis_magang')->index();
            $table->unsignedBigInteger('id_perusahaan')->index();
            $table->unsignedBigInteger('id_lokasi_magang')->index();
            $table->string('judul_lowongan', 150);
            $table->text('deskripsi_lowongan');
            $table->date('tanggal_posting');
            $table->date('batas_akhir_lamaran');
            $table->enum('status', ['Aktif', 'Selesai'])->default('Aktif');
            $table->unsignedBigInteger('id_periode')->index();
            $table->unsignedBigInteger('id_waktu_magang')->index();
            $table->unsignedBigInteger('id_insentif')->index();
            $table->timestamps();

            $table->foreign('id_jenis_magang')->references('id_jenis_magang')->on('m_jenis_magang');
            $table->foreign('id_perusahaan')->references('id_perusahaan')->on('m_perusahaan');
            $table->foreign('id_lokasi_magang')->references('id_lokasi_magang')->on('m_lokasi_magang');
            $table->foreign('id_periode')->references('id_periode')->on('m_periode');
            $table->foreign('id_waktu_magang')->references('id_waktu_magang')->on('m_waktu_magang');
            $table->foreign('id_insentif')->references('id_insentif')->on('m_insentif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_lowongan_magang');
    }
};
