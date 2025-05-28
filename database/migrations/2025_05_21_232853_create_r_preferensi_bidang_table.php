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
        Schema::create('r_preferensi_bidang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_preferensi')->index();
            $table->unsignedBigInteger('id_bidang')->index();
            $table->unsignedTinyInteger('rangking_bidang');
            $table->timestamps();
            
            $table->primary(['id_preferensi', 'id_bidang']);

            $table->foreign('id_preferensi')->references('id_preferensi')->on('r_preferensi_mahasiswa')->onDelete('cascade');
            $table->foreign('id_bidang')->references('id_bidang')->on('m_bidang_keahlian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_preferensi_magang');
    }
};
