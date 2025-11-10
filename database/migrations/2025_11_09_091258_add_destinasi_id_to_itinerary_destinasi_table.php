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
        Schema::table('itinerary_destinasi', function (Blueprint $table) {
            $table->integer('destinasi_id_destinasi', false, true)->length(11)->after('id_itinerary_destinasi');
            $table->foreign('destinasi_id_destinasi')->references('id_destinasi')->on('destinasi')->onDelete('cascade');
            
            // Change jam_kunjungan to string to store "HH:MM - HH:MM WIB"
            $table->string('jam_kunjungan', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itinerary_destinasi', function (Blueprint $table) {
            $table->dropForeign(['destinasi_id_destinasi']);
            $table->dropColumn('destinasi_id_destinasi');
        });
    }
};
