<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopeWithApprovedAverageRating(Builder $query): Builder
    {
        return $query->withAvg([
            'ulasan as computed_average_rating' => function ($avgQuery) {
                $avgQuery->where(function ($condition) {
                    $condition->whereIn('status_verifikasi', ['approved', 'pending'])
                        ->orWhereNull('status_verifikasi');
                });
            },
        ], 'rating');
    }

    public function getAverageRatingAttribute($value): float
    {
        if (array_key_exists('computed_average_rating', $this->attributes)) {
            $computed = $this->attributes['computed_average_rating'];

            return $computed !== null ? (float) $computed : 0.0;
        }

        if (! is_null($value)) {
            return (float) $value;
        }

        $average = $this->ulasan()
            ->where(function ($query) {
                $query->whereIn('status_verifikasi', ['approved', 'pending'])
                    ->orWhereNull('status_verifikasi');
            })
            ->avg('rating');

        return $average ? (float) $average : 0.0;
    }
}
