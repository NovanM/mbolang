<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryDestinasi extends Model
{
    protected $table = 'itinerary_destinasi';
    protected $primaryKey = 'id_itinerary_destinasi';

    protected $fillable = [
        'destinasi_id_destinasi',
        'itinerary_id_itinerary',
        'tanggal_kunjungan',
        'jam_kunjungan',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    // Relationships
    public function itinerary()
    {
        return $this->hasMany(Itinerary::class, 'itinerary_destinasi_id_itinerary_destinasi', 'id_itinerary_destinasi');
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'destinasi_id_destinasi', 'id_destinasi');
    }
}
