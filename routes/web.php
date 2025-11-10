<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LanguageController;

// Language Routes
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Public Routes (Guest bisa akses)
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/destinasi/{id}', [BerandaController::class, 'show'])->name('destinasi.detail');
Route::get('/destinasi/{id}/ulasan', [UlasanController::class, 'index'])->name('destinasi.ulasan');

// Auth Routes (hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Routes (harus login)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Ulasan (harus login untuk tambah)
    Route::get('/destinasi/{id}/tambah-ulasan', [UlasanController::class, 'create'])->name('destinasi.tambah-ulasan');
    Route::post('/destinasi/{id}/tambah-ulasan', [UlasanController::class, 'store'])->name('destinasi.store-ulasan');

    // Booking (harus login)
    Route::get('/destinasi/{id}/pesan-tiket', [BookingController::class, 'bookTicket'])->name('destinasi.pesan-tiket');
    Route::get('/destinasi/{id}/checkout', [BookingController::class, 'checkout'])->name('destinasi.checkout');
    Route::post('/destinasi/{id}/process-payment', [BookingController::class, 'processPayment'])->name('destinasi.process-payment');
    Route::get('/payment/success', [BookingController::class, 'paymentSuccess'])->name('payment.success');

    // Itinerary (harus login)
    Route::get('/perjalanan/buat', [ItineraryController::class, 'create'])->name('itinerary.create');
    Route::post('/perjalanan', [ItineraryController::class, 'store'])->name('itinerary.store');
    Route::get('/perjalanan/{id}', [ItineraryController::class, 'show'])->name('itinerary.show');

    // Plan (harus login)
    Route::get('/plan', [PlanController::class, 'list'])->name('plan.list');
    Route::get('/plan/{itineraryId}', [PlanController::class, 'index'])->name('plan.index');
    Route::post('/plan/{itineraryId}/add-destination', [PlanController::class, 'addDestination'])->name('plan.add-destination');
    Route::post('/plan/{itineraryId}/add-destination-from-detail', [PlanController::class, 'addDestinationFromDetail'])->name('plan.add-destination-from-detail');
    Route::post('/plan/{itineraryId}/save', [PlanController::class, 'saveItinerary'])->name('plan.save');

    // Akun (harus login)
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::get('/akun/favorit', [AkunController::class, 'favorit'])->name('akun.favorit');
    Route::get('/akun/ulasan', [AkunController::class, 'ulasan'])->name('akun.ulasan');
    Route::get('/akun/tiket', [AkunController::class, 'tiket'])->name('akun.tiket');
    Route::delete('/favorit/{id}', [AkunController::class, 'destroyFavorit'])->name('favorit.destroy');
    Route::post('/favorit/{destinasiId}', [AkunController::class, 'toggleFavorit'])->name('favorit.toggle');
});

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Password Reset Routes
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request')->middleware('guest');

// Google OAuth Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// Dashboard (protected route)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');
