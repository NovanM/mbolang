<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    public function create()
    {
        return view('itinerary.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perjalanan' => 'required|string|max:100',
            'tanggal_perjalanan' => 'required|date',
        ]);

        $itinerary = Itinerary::create([
            'pengguna_id_pengguna' => Auth::user()->id_pengguna,
            'nama_itinerary' => $validated['nama_perjalanan'],
            'kategori_perjalanan' => 'wisata', // default value
            'tanggal_mulai' => $validated['tanggal_perjalanan'],
            'tanggal_selesai' => $validated['tanggal_perjalanan'], // same day for now
            'itinerary_destinasi_id_itinerary_destinasi' => null, // will be set when adding destinations
        ]);

        return redirect()
            ->route('plan.index', $itinerary->id_itinerary)
            ->with('success', 'Perjalanan berhasil dibuat! Silakan pilih destinasi.');
    }

    public function show($id)
    {
        $itinerary = Itinerary::with(['pengguna', 'destinasiList.destinasi'])
            ->findOrFail($id);

        return view('itinerary.show', compact('itinerary'));
    }
}
