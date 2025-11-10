<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'nama',
        'email',
        'password_hash',
        'role',
        'status_verifikasi',
        'google_id',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Relationships
    public function admin()
    {
        return $this->hasOne(Admin::class, 'pengguna_id_pengguna', 'id_pengguna');
    }

    public function pengelolaDestinasi()
    {
        return $this->hasOne(PengelolaDestinasi::class, 'pengguna_id_pengguna', 'id_pengguna');
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class, 'pengguna_id_pengguna', 'id_pengguna');
    }

    public function riwayatKunjungan()
    {
        return $this->hasMany(RiwayatKunjungan::class, 'pengguna_id_pengguna', 'id_pengguna');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'pengguna_id_pengguna', 'id_pengguna');
    }
}
