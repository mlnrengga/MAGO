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
        Schema::create('m_dosen_pembimbing', function (Blueprint $table) {
            $table->id('id_dosen');
            $table->unsignedBigInteger('id_user');
            $table->string('nip', 20);
            $table->unsignedBigInteger('id_lokasi_magang');
            $table->unsignedBigInteger('id_jenis_magang');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('m_user');
            $table->foreign('id_lokasi_magang')->references('id_lokasi_magang')->on('m_lokasi_magang');
            $table->foreign('id_jenis_magang')->references('id_jenis_magang')->on('m_jenis_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_dosen_pembimbing');
    }
};
