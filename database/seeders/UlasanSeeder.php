<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\Destinasi;
use App\Models\Ulasan;
use App\Models\RiwayatKunjungan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UlasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users for reviews
        $user1 = Pengguna::create([
            'nama' => 'Traveller_Mbg',
            'email' => 'traveller@example.com',
            'password_hash' => Hash::make('password'),
            'role' => 'user',
            'status_verifikasi' => 'verified',
        ]);

        $user2 = Pengguna::create([
            'nama' => 'Rizkiawan',
            'email' => 'rizki@example.com',
            'password_hash' => Hash::make('password'),
            'role' => 'user',
            'status_verifikasi' => 'verified',
        ]);

        $user3 = Pengguna::create([
            'nama' => 'Nasrul',
            'email' => 'nasrul@example.com',
            'password_hash' => Hash::make('password'),
            'role' => 'user',
            'status_verifikasi' => 'verified',
        ]);

        // Get first destinasi (Jatim Park 1)
        $destinasi = Destinasi::first();

        if ($destinasi) {
            // Create riwayat kunjungan for each user
            $riwayat1 = RiwayatKunjungan::create([
                'destinasi_id_destinasi' => $destinasi->id_destinasi,
                'pengguna_id_pengguna' => $user1->id_pengguna,
                'tanggal_pembelian' => now()->subDays(10),
                'tanggal_kunjungan' => now()->subDays(9),
                'status_pembayaran' => 'success',
                'status_checkin' => 'checked_in',
                'status_ulasan' => 'reviewed',
            ]);

            $riwayat2 = RiwayatKunjungan::create([
                'destinasi_id_destinasi' => $destinasi->id_destinasi,
                'pengguna_id_pengguna' => $user2->id_pengguna,
                'tanggal_pembelian' => now()->subDays(20),
                'tanggal_kunjungan' => now()->subDays(19),
                'status_pembayaran' => 'success',
                'status_checkin' => 'checked_in',
                'status_ulasan' => 'reviewed',
            ]);

            $riwayat3 = RiwayatKunjungan::create([
                'destinasi_id_destinasi' => $destinasi->id_destinasi,
                'pengguna_id_pengguna' => $user3->id_pengguna,
                'tanggal_pembelian' => now()->subDays(15),
                'tanggal_kunjungan' => now()->subDays(14),
                'status_pembayaran' => 'success',
                'status_checkin' => 'checked_in',
                'status_ulasan' => 'reviewed',
            ]);

            // Create ulasan
            Ulasan::create([
                'pengguna_id_pengguna' => $user1->id_pengguna,
                'destinasi_id_destinasi' => $destinasi->id_destinasi,
                'riwayat_kunjungan_id_kunjungan' => $riwayat1->id_kunjungan,
                'rating' => 5,
                'komentar' => 'Wahana di Jatim Park 1 sangat seru dan cocok untuk menghabiskan liburan bersama teman / keluarga. Wahana edukatif, ada museum3 yang sangat menarik!',
                'tanggal_ulasan' => now()->subDays(8),
                'status_verifikasi' => 'verified',
            ]);

            Ulasan::create([
                'pengguna_id_pengguna' => $user2->id_pengguna,
                'destinasi_id_destinasi' => $destinasi->id_destinasi,
                'riwayat_kunjungan_id_kunjungan' => $riwayat2->id_kunjungan,
                'rating' => 4.5,
                'komentar' => 'Banyak pilihan wahana menarik untuk semua usia. Bersih! sampai sekarang masih ada liburan sekolah.',
                'tanggal_ulasan' => now()->subDays(18),
                'status_verifikasi' => 'verified',
            ]);

            Ulasan::create([
                'pengguna_id_pengguna' => $user3->id_pengguna,
                'destinasi_id_destinasi' => $destinasi->id_destinasi,
                'riwayat_kunjungan_id_kunjungan' => $riwayat3->id_kunjungan,
                'rating' => 4,
                'komentar' => 'Tempat wisata yang sangat lengkap dengan wahana permainan yang variatif untuk keluarga.',
                'tanggal_ulasan' => now()->subDays(13),
                'status_verifikasi' => 'verified',
            ]);
        }
    }
}
