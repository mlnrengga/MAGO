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
            $table->foreignId('id_preferensi')->constrained('r_preferensi_mahasiswa')->cascadeOnDelete();
            $table->foreignId('id_jenis_magang')->constrained('m_jenis_magang')->cascadeOnDelete();
            $table->unsignedTinyInteger('ranking_jenis_magang');
            $table->timestamps();

            $table->primary(['id_preferensi', 'id_jenis_magang']);
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
