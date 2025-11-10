<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';

    protected $fillable = [
        'pengguna_id_pengguna',
        'destinasi_id_destinasi',
        'riwayat_kunjungan_id_kunjungan',
        'rating',
        'komentar',
        'tanggal_ulasan',
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_ulasan' => 'datetime',
    ];

    // Relationships
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id_pengguna', 'id_pengguna');
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'destinasi_id_destinasi', 'id_destinasi');
    }

    public function riwayatKunjungan()
    {
        return $this->belongsTo(RiwayatKunjungan::class, 'riwayat_kunjungan_id_kunjungan', 'id_kunjungan');
    }
}
