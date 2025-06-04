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
        Schema::create('t_log_magang', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_penempatan')->index();
            $table->date('tanggal_log');
            $table->text('keterangan');
            $table->enum('status', ['masuk', 'izin', 'sakit', 'cuti']);
            $table->string('file_bukti');
            $table->string('feedback_progres')->nullable();
            $table->timestamps();

            $table->foreign('id_penempatan')->references('id_penempatan')->on('t_penempatan_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_log_magang');
    }
};
