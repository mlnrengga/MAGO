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
        Schema::create('m_mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->unsignedBigInteger('id_user');
            $table->string('nim', 20)->unique();
            $table->unsignedBigInteger('id_prodi')->index();
            $table->decimal('ipk', 4, 2);
            $table->unsignedTinyInteger('semester');
            $table->timestamps();
            
            $table->foreign('id_user')->references('id_user')->on('m_user');
            $table->foreign('id_prodi')->references('id_prodi')->on('m_prodi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mahasiswa');
    }
};
