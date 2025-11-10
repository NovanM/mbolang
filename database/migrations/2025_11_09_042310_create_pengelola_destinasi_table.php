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
        Schema::create('pengelola_destinasi', function (Blueprint $table) {
            $table->integer('id_pengelola', true, true)->length(11);
            $table->integer('pengguna_id_pengguna', false, true)->length(11);
            $table->string('nama_instansi', 100);
            $table->string('kontak_instansi', 100);
            $table->timestamps();

            $table->foreign('pengguna_id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengelola_destinasi');
    }
};
