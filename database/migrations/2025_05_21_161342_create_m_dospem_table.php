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
        Schema::create('m_dospem', function (Blueprint $table) {
            $table->id('id_dospem');
            $table->unsignedBigInteger('id_user')->index();
            $table->string('nip', 20)->unique();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_dospem');
    }
};
