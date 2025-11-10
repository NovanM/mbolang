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
        Schema::create('favorit', function (Blueprint $table) {
            $table->integer('id_favorit', true, true)->length(11);
            $table->integer('pengguna_id_pengguna', false, true)->length(11);
            $table->integer('destinasi_id_destinasi', false, true)->length(11);
            $table->timestamps();

            // Foreign keys
            $table->foreign('pengguna_id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('cascade');

            $table->foreign('destinasi_id_destinasi')
                ->references('id_destinasi')
                ->on('destinasi')
                ->onDelete('cascade');

            // Prevent duplicate favorites
            $table->unique(['pengguna_id_pengguna', 'destinasi_id_destinasi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorit');
    }
};
