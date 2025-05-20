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
        Schema::create('t_penempatan_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('t_pengajuan_magang');
            $table->foreignId('lokasi_id')->constrained('m_lokasi_magang', 'id_lokasi_magang'); // Merujuk ke kolom id_lokasi_magang
            $table->date('tanggal_mulai'); 
            $table->date('tanggal_selesai'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_penempatan_magang');
    }
};
