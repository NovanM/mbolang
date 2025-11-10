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
        Schema::create('destinasi', function (Blueprint $table) {
            $table->integer('id_destinasi', true, true)->length(11);
            $table->integer('admin_id_admin', false, true)->length(11);
            $table->integer('pengelola_destinasi_id_pengelola', false, true)->length(11);
            $table->string('nama_destinasi', 100);
            $table->string('kategori', 50);
            $table->decimal('harga_tiket', 10, 2);
            $table->string('jam_buka', 50);
            $table->string('lokasi', 255);
            $table->float('average_rating', 3, 2)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('status_verifikasi', 20);
            $table->timestamps();

            $table->foreign('admin_id_admin')->references('id_admin')->on('admin')->onDelete('cascade');
            $table->foreign('pengelola_destinasi_id_pengelola')->references('id_pengelola')->on('pengelola_destinasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinasi');
    }
};
