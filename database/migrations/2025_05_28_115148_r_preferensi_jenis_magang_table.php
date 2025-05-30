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
        Schema::create('r_preferensi_jenis_magang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_preferensi');
            $table->unsignedBigInteger('id_jenis_magang');
            $table->timestamps();

            $table->primary(['id_preferensi', 'id_jenis_magang']);

            $table->foreign('id_preferensi')->references('id_preferensi')->on('r_preferensi_mahasiswa')->onDelete('cascade');
            $table->foreign('id_jenis_magang')->references('id_jenis_magang')->on('m_jenis_magang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_preferensi_jenis_magang');
    }
};
