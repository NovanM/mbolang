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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->integer('id_ulasan', true, true)->length(11);
            $table->integer('pengguna_id_pengguna', false, true)->length(11);
            $table->integer('destinasi_id_destinasi', false, true)->length(11);
            $table->integer('riwayat_kunjungan_id_kunjungan', false, true)->length(11);
            $table->integer('rating')->length(11);
            $table->text('komentar')->nullable();
            $table->dateTime('tanggal_ulasan');
            $table->string('status_verifikasi', 20);
            $table->timestamps();

            $table->foreign('pengguna_id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->foreign('destinasi_id_destinasi')->references('id_destinasi')->on('destinasi')->onDelete('cascade');
            $table->foreign('riwayat_kunjungan_id_kunjungan')->references('id_kunjungan')->on('riwayat_kunjungan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
