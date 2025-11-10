<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\Admin;
use App\Models\PengelolaDestinasi;
use App\Models\Destinasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DestinasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $adminUser = Pengguna::create([
            'nama' => 'Admin Mbolang',
            'email' => 'admin@mbolang.com',
            'password_hash' => Hash::make('password'),
            'role' => 'admin',
            'status_verifikasi' => 'verified',
        ]);

        $admin = Admin::create([
            'pengguna_id_pengguna' => $adminUser->id_pengguna,
            'jabatan' => 'Super Admin',
            'no_telepon' => '081234567890',
        ]);

        // Create pengelola user
        $pengelolaUser = Pengguna::create([
            'nama' => 'Pengelola Destinasi Bali',
            'email' => 'pengelola@bali.com',
            'password_hash' => Hash::make('password'),
            'role' => 'pengelola',
            'status_verifikasi' => 'verified',
        ]);

        $pengelola = PengelolaDestinasi::create([
            'pengguna_id_pengguna' => $pengelolaUser->id_pengguna,
            'nama_instansi' => 'Dinas Pariwisata Bali',
            'kontak_instansi' => '0361234567',
        ]);

        // Create destinasi
        $destinasiData = [
            [
                'admin_id_admin' => $admin->id_admin,
                'pengelola_destinasi_id_pengelola' => $pengelola->id_pengelola,
                'nama_destinasi' => 'Jatim Park 1',
                'kategori' => 'Wahana Bermain',
                'harga_tiket' => 50000,
                'jam_buka' => '09:00 - 17:00',
                'lokasi' => 'Batu, Jawa Timur',
                'average_rating' => 4.0,
                'deskripsi' => 'Taman rekreasi dengan berbagai wahana edukatif dan hiburan untuk keluarga.',
                'status_verifikasi' => 'verified',
                'foto' => 'images/destinasi/jatimpark.png',
            ],
            [
                'admin_id_admin' => $admin->id_admin,
                'pengelola_destinasi_id_pengelola' => $pengelola->id_pengelola,
                'nama_destinasi' => 'Batu Night Spectacular',
                'kategori' => 'Wahana Bermain',
                'harga_tiket' => 75000,
                'jam_buka' => '15:00 - 23:00',
                'lokasi' => 'Batu, Jawa Timur',
                'average_rating' => 4.5,
                'deskripsi' => 'Taman rekreasi malam hari dengan lampu warna-warni dan wahana permainan.',
                'status_verifikasi' => 'verified',
                'foto' => 'images/destinasi/batunightspectacular.png',
            ],
            [
                'admin_id_admin' => $admin->id_admin,
                'pengelola_destinasi_id_pengelola' => $pengelola->id_pengelola,
                'nama_destinasi' => 'Bedengan Camping Ground',
                'kategori' => 'Wisata Alam',
                'harga_tiket' => 25000,
                'jam_buka' => '24 Jam',
                'lokasi' => 'Kabupaten Malang, Jawa Timur',
                'average_rating' => 4.3,
                'deskripsi' => 'Area camping dengan pemandangan alam yang indah dan suasana yang sejuk.',
                'status_verifikasi' => 'verified',
                'foto' => 'images/destinasi/bedengan.png',
            ],
            [
                'admin_id_admin' => $admin->id_admin,
                'pengelola_destinasi_id_pengelola' => $pengelola->id_pengelola,
                'nama_destinasi' => 'Kayutangan Heritage',
                'kategori' => 'Wisata Kuliner',
                'harga_tiket' => 0,
                'jam_buka' => '06:00 - 22:00',
                'lokasi' => 'Kota Malang, Jawa Timur',
                'average_rating' => 4.2,
                'deskripsi' => 'Kawasan heritage dengan bangunan bersejarah dan berbagai kuliner khas Malang.',
                'status_verifikasi' => 'verified',
                'foto' => 'images/destinasi/kayutangan.png',
            ],
            [
                'admin_id_admin' => $admin->id_admin,
                'pengelola_destinasi_id_pengelola' => $pengelola->id_pengelola,
                'nama_destinasi' => 'Bromo Tengger Semeru',
                'kategori' => 'Wisata Alam',
                'harga_tiket' => 35000,
                'jam_buka' => '24 Jam',
                'lokasi' => 'Semeru, Jawa Timur',
                'average_rating' => 4.8,
                'deskripsi' => 'Gunung berapi aktif dengan pemandangan sunrise yang spektakuler.',
                'status_verifikasi' => 'verified',
                'foto' => 'images/destinasi/bromo.png',
            ],
            [
                'admin_id_admin' => $admin->id_admin,
                'pengelola_destinasi_id_pengelola' => $pengelola->id_pengelola,
                'nama_destinasi' => 'Jatim Park 2',
                'kategori' => 'Wahana Bermain',
                'harga_tiket' => 120000,
                'jam_buka' => '08:30 - 16:30',
                'lokasi' => 'Batu, Jawa Timur',
                'average_rating' => 4.6,
                'deskripsi' => 'Taman rekreasi dengan museum satwa, secret zoo, dan berbagai wahana edukatif.',
                'status_verifikasi' => 'verified',
                'foto' => 'images/destinasi/jatimpark2.png',
            ],
        ];

        foreach ($destinasiData as $destinasi) {
            Destinasi::create($destinasi);
        }
    }
}
