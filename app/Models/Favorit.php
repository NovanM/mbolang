<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    protected $table = 'favorit';
    protected $primaryKey = 'id_favorit';

    protected $fillable = [
        'pengguna_id_pengguna',
        'destinasi_id_destinasi',
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
