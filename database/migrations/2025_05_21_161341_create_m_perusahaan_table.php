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
        Schema::create('m_perusahaan', function (Blueprint $table) {
            $table->id('id_perusahaan');
            $table->unsignedBigInteger('id_admin')->index();
            $table->string('alamat');
            $table->string('no_telepon', 20);
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->string('nama');
            $table->timestamps();

            $table->foreign('id_admin')->references('id_admin')->on('m_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_perusahaan');
    }
};
