<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'riwayat_kunjungan_id_kunjungan',
        'metode_pembayaran',
        'total_bayar',
        'tanggal_bayar',
        'status_pembayaran',
    ];

    protected $casts = [
        'total_bayar' => 'decimal:2',
        'tanggal_bayar' => 'datetime',
    ];

    // Relationships
    public function riwayatKunjungan()
    {
        return $this->belongsTo(RiwayatKunjungan::class, 'riwayat_kunjungan_id_kunjungan', 'id_kunjungan');
    }
}
