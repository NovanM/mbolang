<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorit;
use App\Models\Ulasan;

class AkunController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('akun.index', compact('user'));
    }

    public function favorit()
    {
        $user = Auth::user();
        $favorits = Favorit::where('pengguna_id_pengguna', $user->id_pengguna)
            ->with(['destinasi' => function ($query) {
                $query->withApprovedAverageRating();
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('akun.favorit', compact('favorits'));
    }

    public function ulasan()
    {
        $user = Auth::user();
        $ulasans = Ulasan::where('pengguna_id_pengguna', $user->id_pengguna)
            ->with(['destinasi' => function ($query) {
                $query->withApprovedAverageRating();
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('akun.ulasan', compact('ulasans'));
    }

    public function tiket()
    {
        // Booking data is currently unavailable because the related table is not implemented yet.
        $bookings = collect();

        return view('akun.tiket', compact('bookings'));
    }

    public function editUlasan(Ulasan $ulasan)
    {
        $this->authorizeUlasanOwnership($ulasan);

        $ulasan->load('destinasi');

        return view('akun.edit-ulasan', compact('ulasan'));
    }

    public function updateUlasan(Request $request, Ulasan $ulasan)
    {
        $this->authorizeUlasanOwnership($ulasan);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        $ulasan->update([
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar'],
            'tanggal_ulasan' => now(),
            'status_verifikasi' => 'pending',
        ]);

        return redirect()
            ->route('akun.ulasan')
            ->with('success', __('messages.review_update_success'));
    }

    public function destroyUlasan(Ulasan $ulasan)
    {
        $this->authorizeUlasanOwnership($ulasan);

        $ulasan->delete();

        return redirect()
            ->route('akun.ulasan')
            ->with('success', __('messages.review_delete_success'));
    }

    private function authorizeUlasanOwnership(Ulasan $ulasan): void
    {
        if ($ulasan->pengguna_id_pengguna !== Auth::user()->id_pengguna) {
            abort(403);
        }
    }

    public function destroyFavorit($id)
    {
        $favorit = Favorit::where('id_favorit', $id)
            ->where('pengguna_id_pengguna', Auth::user()->id_pengguna)
            ->firstOrFail();

        $favorit->delete();

        return redirect()
            ->route('akun.favorit')
            ->with('success', 'Destinasi berhasil dihapus dari favorit');
    }

    public function toggleFavorit($destinasiId)
    {
        $user = Auth::user();
        
        $favorit = Favorit::where('pengguna_id_pengguna', $user->id_pengguna)
            ->where('destinasi_id_destinasi', $destinasiId)
            ->first();

        if ($favorit) {
            // Already favorited, remove it
            $favorit->delete();
            $message = 'Destinasi berhasil dihapus dari favorit';
        } else {
            // Not favorited yet, add it
            Favorit::create([
                'pengguna_id_pengguna' => $user->id_pengguna,
                'destinasi_id_destinasi' => $destinasiId,
            ]);
            $message = 'Destinasi berhasil ditambahkan ke favorit';
        }

        return back()->with('success', $message);
    }
}
