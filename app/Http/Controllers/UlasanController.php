<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
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

        // TODO: Get authenticated user ID
        // For now, using a default user or guest mode
        $idPengguna = 1; // Replace with auth()->user()->id_pengguna when auth is implemented

        // Create the review
        \App\Models\Ulasan::create([
            'pengguna_id_pengguna' => $idPengguna,
            'destinasi_id_destinasi' => $destinasi->id_destinasi,
            'riwayat_kunjungan_id_kunjungan' => null, // Will be filled after visit
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
