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
            $table->unsignedBigInteger('id_mahasiswa')->unique();
        
            $table->unsignedBigInteger('id_daerah_magang');
            $table->unsignedTinyInteger('ranking_daerah');

            $table->unsignedBigInteger('id_waktu_magang');
            $table->unsignedTinyInteger('ranking_waktu_magang');

            $table->unsignedBigInteger('id_insentif');
            $table->unsignedTinyInteger('ranking_insentif');
            
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('m_mahasiswa');
            $table->foreign('id_daerah_magang')->references('id_daerah_magang')->on('m_daerah_magang');
            $table->foreign('id_waktu_magang')->references('id_waktu_magang')->on('m_waktu_magang');
            $table->foreign('id_insentif')->references('id_insentif')->on('m_insentif');

            
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
