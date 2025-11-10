<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destinasi extends Model
{
    protected $table = 'destinasi';
    protected $primaryKey = 'id_destinasi';

    protected $fillable = [
        'admin_id_admin',
        'pengelola_destinasi_id_pengelola',
        'nama_destinasi',
        'kategori',
        'harga_tiket',
        'jam_buka',
        'lokasi',
        'average_rating',
        'deskripsi',
        'foto',
        'status_verifikasi',
    ];

    protected $casts = [
        'harga_tiket' => 'decimal:2',
        'average_rating' => 'float',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id_admin', 'id_admin');
    }

    public function pengelolaDestinasi()
    {
        return $this->belongsTo(PengelolaDestinasi::class, 'pengelola_destinasi_id_pengelola', 'id_pengelola');
    }

    public function riwayatKunjungan()
    {
        return $this->hasMany(RiwayatKunjungan::class, 'destinasi_id_destinasi', 'id_destinasi');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'destinasi_id_destinasi', 'id_destinasi');
    }
}
