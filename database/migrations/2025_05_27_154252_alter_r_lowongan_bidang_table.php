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
        //
        Schema::table('r_lowongan_bidang', function (Blueprint $table) {
            $table->dropForeign(['id_lowongan']);

            $table->foreign('id_lowongan')
                ->references('id_lowongan')
                ->on('t_lowongan_magang')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('r_lowongan_bidang', function (Blueprint $table) {
            // Remove the cascade constraint
            $table->dropForeign(['id_lowongan']);

            $table->foreign('id_lowongan')
                ->references('id_lowongan')
                ->on('t_lowongan_magang');
        });
    }
};
