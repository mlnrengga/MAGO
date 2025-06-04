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
            $table->string('alamat');
            $table->string('no_telepon', 20);
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->string('nama');
            $table->enum('partnership', ['Perusahaan Mitra', 'Perusahaan Non-Mitra'])->default('Perusahaan Mitra');
            $table->timestamps();

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
