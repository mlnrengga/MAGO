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
        Schema::create('m_daerah_magang', function (Blueprint $table) {
            $table->id('id_daerah_magang');
            $table->string('nama_daerah');
            $table->enum('jenis_daerah', ['Kota', 'Kabupaten']);
            $table->unsignedBigInteger('id_provinsi');
            $table->foreign('id_provinsi')
                  ->references('id_provinsi')
                  ->on('m_provinsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_daerah_magang');
    }
};
