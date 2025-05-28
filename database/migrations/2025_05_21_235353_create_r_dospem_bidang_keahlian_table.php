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
        Schema::create('r_dospem_bidang_keahlian', function (Blueprint $table) {
            $table->unsignedBigInteger('id_dospem')->index()->onDelete('cascade');
            $table->unsignedBigInteger('id_bidang')->index()->onDelete('cascade');
            $table->timestamps();
            
            $table->primary(['id_dospem', 'id_bidang']);

            $table->foreign('id_dospem')->references('id_dospem')->on('m_dospem');
            $table->foreign('id_bidang')->references('id_bidang')->on('m_bidang_keahlian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_dospem_bidang_keahlian');
    }
};
