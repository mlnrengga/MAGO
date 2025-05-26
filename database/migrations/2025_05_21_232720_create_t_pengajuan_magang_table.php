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
        Schema::create('t_pengajuan_magang', function (Blueprint $table) {
            $table->id('id_pengajuan');
            $table->unsignedBigInteger('id_mahasiswa')->index();
            $table->unsignedBigInteger('id_lowongan')->index();
            $table->date('tanggal_pengajuan');
            $table->enum('status', ['Diajukan', 'Diterima', 'Ditolak']);
            $table->date('tanggal_diterima')->nullable();
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('m_mahasiswa');
            $table->foreign('id_lowongan')->references('id_lowongan')->on('t_lowongan_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pengajuan_magang');
    }
};
