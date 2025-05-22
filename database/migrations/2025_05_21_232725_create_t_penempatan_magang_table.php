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
            $table->id('id_penempatan');
            $table->unsignedBigInteger('id_mahasiswa')->index();
            $table->unsignedBigInteger('id_pengajuan')->index();
            $table->enum('status', ['Berlangsung', 'Selesai']);
            $table->timestamps();
            
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('m_mahasiswa');
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('t_pengajuan_magang');
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
