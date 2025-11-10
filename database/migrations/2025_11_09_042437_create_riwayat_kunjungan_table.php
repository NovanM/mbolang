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
        Schema::create('riwayat_kunjungan', function (Blueprint $table) {
            $table->integer('id_kunjungan', true, true)->length(11);
            $table->integer('pembayaran_id_pembayaran', false, true)->length(11)->nullable();
            $table->integer('destinasi_id_destinasi', false, true)->length(11);
            $table->integer('pengguna_id_pengguna', false, true)->length(11);
            $table->dateTime('tanggal_pembelian');
            $table->date('tanggal_kunjungan');
            $table->string('status_pembayaran', 20);
            $table->string('status_checkin', 20);
            $table->string('status_ulasan', 20);
            $table->timestamps();

            $table->foreign('destinasi_id_destinasi')->references('id_destinasi')->on('destinasi')->onDelete('cascade');
            $table->foreign('pengguna_id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_kunjungan');
    }
};
