<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKunjungan extends Model
{
    protected $table = 'riwayat_kunjungan';
    protected $primaryKey = 'id_kunjungan';

    protected $fillable = [
        'pembayaran_id_pembayaran',
        'destinasi_id_destinasi',
        'pengguna_id_pengguna',
        'tanggal_pembelian',
        'tanggal_kunjungan',
        'status_pembayaran',
        'status_checkin',
        'status_ulasan',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'datetime',
        'tanggal_kunjungan' => 'date',
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

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id_pembayaran', 'id_pembayaran');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'riwayat_kunjungan_id_kunjungan', 'id_kunjungan');
    }
}
