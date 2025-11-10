<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id_booking';

    protected $fillable = [
        'destinasi_id_destinasi',
        'pengguna_id_pengguna',
        'status_pembayaran',
        'metode_pembayaran',
        'tanggal_pembelian',
        'tanggal_kunjungan',
        'jumlah_tiket',
        'total_harga',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'tanggal_kunjungan' => 'date',
        'total_harga' => 'decimal:2',
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
}
