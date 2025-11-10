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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->integer('id_pembayaran', true, true)->length(11);
            $table->integer('riwayat_kunjungan_id_kunjungan', false, true)->length(11);
            $table->string('metode_pembayaran', 20);
            $table->decimal('total_bayar', 10, 2);
            $table->dateTime('tanggal_bayar');
            $table->string('status_pembayaran', 20);
            $table->timestamps();

            $table->foreign('riwayat_kunjungan_id_kunjungan')->references('id_kunjungan')->on('riwayat_kunjungan')->onDelete('cascade');
        });

        // Add foreign key to riwayat_kunjungan after pembayaran table is created
        Schema::table('riwayat_kunjungan', function (Blueprint $table) {
            $table->foreign('pembayaran_id_pembayaran')->references('id_pembayaran')->on('pembayaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
