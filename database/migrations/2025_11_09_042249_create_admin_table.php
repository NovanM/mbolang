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
        Schema::create('admin', function (Blueprint $table) {
            $table->integer('id_admin', true, true)->length(11);
            $table->integer('pengguna_id_pengguna', false, true)->length(11);
            $table->string('jabatan', 50);
            $table->string('no_telepon', 20);
            $table->timestamps();

            $table->foreign('pengguna_id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
