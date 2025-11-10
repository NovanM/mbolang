<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengelolaDestinasi extends Model
{
    protected $table = 'pengelola_destinasi';
    protected $primaryKey = 'id_pengelola';

    protected $fillable = [
        'pengguna_id_pengguna',
        'nama_instansi',
        'kontak_instansi',
    ];

    // Relationships
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id_pengguna', 'id_pengguna');
    }

    public function destinasi()
    {
        return $this->hasMany(Destinasi::class, 'pengelola_destinasi_id_pengelola', 'id_pengelola');
    }
}
