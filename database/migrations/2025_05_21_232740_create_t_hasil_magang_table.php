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
        Schema::create('t_hasil_magang', function (Blueprint $table) {
            $table->id('id_hasil_magang');
            $table->unsignedBigInteger('id_penempatan')->index();
            $table->string('nama_dokumen');
            $table->string('path_dokumen');
            $table->enum('jenis_dokumen', ['Sertifikat', 'Surat Keterangan Magang']);
            $table->text('feedback_magang');
            $table->date('tanggal_upload');
            $table->timestamps();

            $table->foreign('id_penempatan')->references('id_penempatan')->on('t_penempatan_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_hasil_magang');
    }
};
