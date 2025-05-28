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
        Schema::table('r_preferensi_mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bidang')->after('id_mahasiswa');
            $table->unsignedTinyInteger('ranking_bidang')->after('id_bidang');

            $table->foreign('id_bidang')->references('id_bidang')->on('m_bidang_keahlian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('r_preferensi_mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['id_bidang']);
            $table->dropColumn(['id_bidang', 'ranking_bidang']);
        });
    }
};
