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
        Schema::create('r_bimbingan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_dospem')->index();
            $table->unsignedBigInteger('id_penempatan')->index();
            
            $table->primary(['id_dospem', 'id_penempatan']);

            $table->foreign('id_dospem')->references('id_dospem')->on('m_dospem');
            $table->foreign('id_penempatan')->references('id_penempatan')->on('t_penempatan_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_bimbingan');
    }
};
