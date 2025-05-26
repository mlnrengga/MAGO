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
            $table->id('id_user');
            $table->unsignedBigInteger('id_role')->index();
            $table->string('nama');
            $table->string('password');
            $table->string('alamat');
            $table->string('no_telepon', 20);
            $table->string('profile_picture')->nullable();
            $table->timestamps();

            $table->foreign('id_role')->references('id_role')->on('m_role');
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
