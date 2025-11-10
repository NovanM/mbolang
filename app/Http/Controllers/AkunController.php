<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorit;
use App\Models\Ulasan;
use App\Models\Booking;

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
            ->with('destinasi')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('akun.favorit', compact('favorits'));
    }

    public function ulasan()
    {
        $user = Auth::user();
        $ulasans = Ulasan::where('pengguna_id_pengguna', $user->id_pengguna)
            ->with('destinasi')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('akun.ulasan', compact('ulasans'));
    }

    public function tiket()
    {
        $user = Auth::user();
        $bookings = Booking::where('pengguna_id_pengguna', $user->id_pengguna)
            ->with('destinasi')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('akun.tiket', compact('bookings'));
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
