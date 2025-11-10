<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $table = 'itinerary';
    protected $primaryKey = 'id_itinerary';

    protected $fillable = [
        'itinerary_destinasi_id_itinerary_destinasi',
        'pengguna_id_pengguna',
        'nama_itinerary',
        'kategori_perjalanan',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Relationships
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id_pengguna', 'id_pengguna');
    }

    public function itineraryDestinasi()
    {
        return $this->belongsTo(ItineraryDestinasi::class, 'itinerary_destinasi_id_itinerary_destinasi', 'id_itinerary_destinasi');
    }

    // Get all destinations for this itinerary
    public function destinasiList()
    {
        return $this->hasMany(ItineraryDestinasi::class, 'itinerary_id_itinerary', 'id_itinerary');
    }
}
