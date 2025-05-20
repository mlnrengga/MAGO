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
        Schema::create('m_user', function (Blueprint $table) {
            $table->id("id_user");
            $table->string('nama', 100);
            $table->string('password', 255);
            $table->string('alamat', 255);
            $table->string('no_telepon', 20);
            $table->string('profile_picture', 255);
            $table->enum('role', ['admin', 'mahasiswa', 'dosen_pembimbing']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user');
    }
};
