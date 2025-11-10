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
        // Add foreign key from itinerary_destinasi to itinerary
        Schema::table('itinerary_destinasi', function (Blueprint $table) {
            $table->foreign('itinerary_id_itinerary')->references('id_itinerary')->on('itinerary')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itinerary_destinasi', function (Blueprint $table) {
            $table->dropForeign(['itinerary_id_itinerary']);
        });
    }
};
