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
        Schema::create('itinerary', function (Blueprint $table) {
            $table->integer('id_itinerary', true, true)->length(11);
            $table->integer('itinerary_destinasi_id_itinerary_destinasi', false, true)->length(11)->nullable();
            $table->integer('pengguna_id_pengguna', false, true)->length(11);
            $table->string('nama_itinerary', 100);
            $table->string('kategori_perjalanan', 100);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();

            $table->foreign('itinerary_destinasi_id_itinerary_destinasi')->references('id_itinerary_destinasi')->on('itinerary_destinasi')->onDelete('cascade');
            $table->foreign('pengguna_id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary');
    }
};
