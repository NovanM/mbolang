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
        Schema::create('itinerary_destinasi', function (Blueprint $table) {
            $table->integer('id_itinerary_destinasi', true, true)->length(11);
            $table->integer('itinerary_id_itinerary', false, true)->length(11)->nullable();
            $table->date('tanggal_kunjungan');
            $table->time('jam_kunjungan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_destinasi');
    }
};
