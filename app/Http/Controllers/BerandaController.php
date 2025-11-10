<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $query = Destinasi::with(['admin', 'pengelolaDestinasi'])
            ->where('status_verifikasi', 'verified');

        // Search by nama destinasi or lokasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_destinasi', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Filter by kategori
        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->whereIn('kategori', $request->kategori);
        }

        // Filter by harga
        if ($request->filled('harga_min')) {
            $query->where('harga_tiket', '>=', $request->harga_min);
        }

        if ($request->filled('harga_max')) {
            $query->where('harga_tiket', '<=', $request->harga_max);
        }

        // TODO: Filter by fasilitas and keperluan (requires additional database fields/tables)

        $destinasi = $query->get();

        return view('beranda', compact('destinasi'));
    }

    public function show($id)
    {
        $destinasi = Destinasi::with(['admin', 'pengelolaDestinasi', 'ulasan.pengguna'])
            ->findOrFail($id);

        // Check if already favorited by current user
        $isFavorited = false;
        $userItineraries = collect();
        
        if (Auth::check()) {
            $isFavorited = \App\Models\Favorit::where('pengguna_id_pengguna', Auth::user()->id_pengguna)
                ->where('destinasi_id_destinasi', $id)
                ->exists();
            
            // Get user's itineraries for "Add to Plan" feature
            $userItineraries = \App\Models\Itinerary::where('pengguna_id_pengguna', Auth::user()->id_pengguna)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('destinasi.detail', compact('destinasi', 'isFavorited', 'userItineraries'));
    }
}
