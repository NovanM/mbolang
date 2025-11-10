<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\ItineraryDestinasi;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function list()
    {
        // Get all itineraries for current user with their destinations
        $itineraries = Itinerary::where('pengguna_id_pengguna', Auth::user()->id_pengguna)
            ->whereHas('destinasiList.destinasi')
            ->with(['destinasiList.destinasi' => function ($query) {
                $query->withApprovedAverageRating();
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('plan.list', compact('itineraries'));
    }

    public function index($itineraryId)
    {
        $itinerary = Itinerary::with(['destinasiList.destinasi'])
            ->findOrFail($itineraryId);
        
        $destinasi = Destinasi::withApprovedAverageRating()
            ->where('status_verifikasi', 'verified')
            ->get();

        return view('plan.index', compact('itinerary', 'destinasi'));
    }

    public function addDestination(Request $request, $itineraryId)
    {
        $validated = $request->validate([
            'destinasi_id' => 'required|exists:destinasi,id_destinasi',
            'jam_mulai' => 'required|string',
            'jam_selesai' => 'required|string',
        ]);

        // Create itinerary_destinasi record
        $itineraryDestinasi = \App\Models\ItineraryDestinasi::create([
            'destinasi_id_destinasi' => $validated['destinasi_id'],
            'jam_kunjungan' => $validated['jam_mulai'] . ' - ' . $validated['jam_selesai'],
        ]);

        // Update itinerary to link to this itinerary_destinasi (if not set)
        $itinerary = Itinerary::findOrFail($itineraryId);
        if (!$itinerary->itinerary_destinasi_id_itinerary_destinasi) {
            $itinerary->itinerary_destinasi_id_itinerary_destinasi = $itineraryDestinasi->id_itinerary_destinasi;
            $itinerary->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Destinasi berhasil ditambahkan'
        ]);
    }

    public function saveItinerary(Request $request, $itineraryId)
    {
        $validated = $request->validate([
            'destinations' => 'required|array|min:1',
            'destinations.*.destinasi_id' => 'required|exists:destinasi,id_destinasi',
            'destinations.*.jam_mulai' => 'required|string',
            'destinations.*.jam_selesai' => 'required|string',
            'destinations.*.phone' => 'nullable|string',
        ]);

        $itinerary = Itinerary::findOrFail($itineraryId);

        // For simplicity, we'll store destinations in a separate table
        // But since the ERD structure is complex, let's use a workaround
        // Store destinations info in session or create junction records
        
        // Create itinerary_destinasi records for each destination
        foreach ($validated['destinations'] as $index => $dest) {
            $itineraryDestinasi = \App\Models\ItineraryDestinasi::create([
                'destinasi_id_destinasi' => $dest['destinasi_id'],
                'itinerary_id_itinerary' => $itineraryId,
                'jam_kunjungan' => $dest['jam_mulai'] . ' - ' . $dest['jam_selesai'] . ' WIB',
                'tanggal_kunjungan' => $itinerary->tanggal_mulai,
            ]);

            // Link first destination to itinerary (ERD requirement)
            if ($index === 0 && !$itinerary->itinerary_destinasi_id_itinerary_destinasi) {
                $itinerary->itinerary_destinasi_id_itinerary_destinasi = $itineraryDestinasi->id_itinerary_destinasi;
                $itinerary->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Itinerary berhasil disimpan'
        ]);
    }

    public function addDestinationFromDetail(Request $request, $itineraryId)
    {
        $validated = $request->validate([
            'destinasi_id' => 'required|exists:destinasi,id_destinasi',
            'jam_mulai' => 'required|string',
            'jam_selesai' => 'required|string',
        ]);

        $itinerary = Itinerary::findOrFail($itineraryId);

        // Create ItineraryDestinasi
        $itineraryDestinasi = ItineraryDestinasi::create([
            'destinasi_id_destinasi' => $validated['destinasi_id'],
            'itinerary_id_itinerary' => $itineraryId,
            'jam_kunjungan' => $validated['jam_mulai'] . ' - ' . $validated['jam_selesai'] . ' WIB',
            'tanggal_kunjungan' => $itinerary->tanggal_mulai,
        ]);

        // If this is the first destination, link it to itinerary
        if ($itinerary->itinerary_destinasi_id_itinerary_destinasi === null) {
            $itinerary->itinerary_destinasi_id_itinerary_destinasi = $itineraryDestinasi->id_itinerary_destinasi;
            $itinerary->save();
        }

        return response()->json(['success' => true, 'message' => 'Destinasi berhasil ditambahkan']);
    }

    public function removeDestination($itineraryId, $destinationId)
    {
        $itinerary = Itinerary::where('pengguna_id_pengguna', Auth::user()->id_pengguna)
            ->findOrFail($itineraryId);

        $destination = ItineraryDestinasi::where('itinerary_id_itinerary', $itineraryId)
            ->where('id_itinerary_destinasi', $destinationId)
            ->firstOrFail();

        if ($itinerary->itinerary_destinasi_id_itinerary_destinasi === $destination->id_itinerary_destinasi) {
            $itinerary->itinerary_destinasi_id_itinerary_destinasi = null;
            $itinerary->save();
        }

        $destination->delete();

        return redirect()
            ->route('itinerary.show', $itineraryId)
            ->with('success', __('messages.plan_destination_removed'));
    }
}
