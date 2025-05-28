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
        Schema::create('r_lowongan_bidang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_lowongan')->index();
            $table->unsignedBigInteger('id_bidang')->index();
            $table->timestamps();

            $table->primary(['id_lowongan', 'id_bidang']);

            $table->foreign('id_lowongan')->references('id_lowongan')->on('t_lowongan_magang')->onDelete('cascade');
            $table->foreign('id_bidang')->references('id_bidang')->on('m_bidang_keahlian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_lowongan_bidang');
    }
};
