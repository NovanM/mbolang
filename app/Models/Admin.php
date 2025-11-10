<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'pengguna_id_pengguna',
        'jabatan',
        'no_telepon',
    ];

    // Relationships
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id_pengguna', 'id_pengguna');
    }

    public function destinasi()
    {
        return $this->hasMany(Destinasi::class, 'admin_id_admin', 'id_admin');
    }
}
