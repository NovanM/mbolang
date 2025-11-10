<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\RiwayatKunjungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index($id)
    {
        $destinasi = Destinasi::with(['ulasan.pengguna'])
            ->findOrFail($id);

        return view('destinasi.ulasan', compact('destinasi'));
    }

    public function create($id)
    {
        $destinasi = Destinasi::with(['ulasan.pengguna'])
            ->findOrFail($id);

        return view('destinasi.tambah-ulasan', compact('destinasi'));
    }

    public function store($id, Request $request)
    {
        $destinasi = Destinasi::findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        $pengguna = Auth::user();
        $idPengguna = $pengguna ? $pengguna->id_pengguna : 1;

        $riwayat = RiwayatKunjungan::where('pengguna_id_pengguna', $idPengguna)
            ->where('destinasi_id_destinasi', $destinasi->id_destinasi)
            ->latest('tanggal_kunjungan')
            ->first();

        if (! $riwayat) {
            $riwayat = RiwayatKunjungan::create([
                'destinasi_id_destinasi' => $destinasi->id_destinasi,
                'pengguna_id_pengguna' => $idPengguna,
                'tanggal_pembelian' => now(),
                'tanggal_kunjungan' => now()->toDateString(),
                'status_pembayaran' => 'pending',
                'status_checkin' => 'pending',
                'status_ulasan' => 'pending',
            ]);
        }

        \App\Models\Ulasan::create([
            'pengguna_id_pengguna' => $idPengguna,
            'destinasi_id_destinasi' => $destinasi->id_destinasi,
            'riwayat_kunjungan_id_kunjungan' => $riwayat->id_kunjungan,
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar'],
            'tanggal_ulasan' => now(),
            'status_verifikasi' => 'pending', // Admin will verify later
        ]);

        // Redirect back to detail page with success message
        return redirect()
            ->route('destinasi.detail', $destinasi->id_destinasi)
            ->with('success', 'Ulasan berhasil ditambahkan! Menunggu verifikasi admin.');
    }
}
