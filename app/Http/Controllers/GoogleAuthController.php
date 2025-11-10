<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google authentication page
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Find or create user
            $user = Pengguna::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // User exists, just login
                Auth::login($user);
            } else {
                // Create new user
                $user = Pengguna::create([
                    'nama' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password_hash' => Hash::make(uniqid()), // Random password for Google users
                    'role' => 'user',
                    'status_verifikasi' => 'verified', // Auto-verify Google users
                    'google_id' => $googleUser->getId(),
                ]);
                
                Auth::login($user);
            }
            
            return redirect()->route('beranda')->with('success', 'Berhasil login dengan Google!');
            
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }
}
