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
        Schema::create('m_mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->unsignedBigInteger('id_user');
            $table->string('nim', 20)->unique();
            $table->string('program_studi', 100);
            $table->string('status_pengajuan_magang', 50);
            $table->timestamps();
            
            $table->foreign('id_user')->references('id_user')->on('m_user');

            // Optional constraint untuk status (kalau kamu mau pakai ENUM-style check)
            // $table->check("status_pengajuan_magang IN ('belum', 'diproses', 'diterima', 'ditolak', 'selesai')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mahasiswa');
    }
};
