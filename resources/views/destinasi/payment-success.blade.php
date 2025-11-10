@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Success Card -->
        <div class="bg-white rounded-3xl shadow-lg border-4 border-[#3F51B5] p-8 text-center">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-[#3F51B5] mb-2">{{ $destinasiName ?? 'Destinasi' }}</h1>
            
            <!-- Ticket Info -->
            <div class="text-left mb-6">
                <p class="text-gray-700 mb-1">Tiket Masuk {{ $destinasiName ?? 'Destinasi' }} + Eco Green Park</p>
                <p class="text-gray-700 mb-1">{{ $quantity ?? 5 }} Tiket</p>
                <p class="text-gray-700">{{ \Carbon\Carbon::parse($date ?? now())->locale('id')->isoFormat('D MMMM YYYY') }}</p>
            </div>

            <!-- Success Message -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[#00BCD4] mb-4">Pembayaran Telah Berhasil!</h2>
                <!-- Party Emoji -->
                <div class="text-6xl mb-4">🎉</div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('akun.tiket') }}" class="block w-full bg-[#3F51B5] hover:bg-[#1E3A8A] text-white font-semibold py-3 rounded-lg transition duration-200">
                    Lihat Tiket Saya
                </a>
                <a href="{{ route('beranda') }}" class="block w-full bg-white border-2 border-[#3F51B5] text-[#3F51B5] hover:bg-gray-50 font-semibold py-3 rounded-lg transition duration-200">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
