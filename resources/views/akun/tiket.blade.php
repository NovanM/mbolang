@extends('layouts.app')

@section('title', 'Tiket yang Terpesan - Mbolang')

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-[#3F51B5]">Tiket yang Terpesan</h1>
            <a href="{{ route('akun.index') }}" class="text-[#3F51B5] hover:text-[#2c3a7f] font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Tiket List -->
        @if($bookings->count() > 0)
            <div class="space-y-6">
                @foreach($bookings as $booking)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition overflow-hidden border border-gray-200">
                    <div class="flex">
                        <!-- Image -->
                        <img src="https://picsum.photos/seed/{{ $booking->destinasi->id_destinasi }}/250/250" 
                             alt="{{ $booking->destinasi->nama_destinasi }}" 
                             class="w-48 h-full object-cover">
                        
                        <!-- Content -->
                        <div class="flex-1 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-[#3F51B5] mb-1">{{ $booking->destinasi->nama_destinasi }}</h3>
                                    <p class="text-gray-600 text-sm">Booking ID: #{{ str_pad($booking->id_booking, 6, '0', STR_PAD_LEFT) }}</p>
                                </div>
                                <span class="px-4 py-1 rounded-full text-sm font-semibold
                                    @if($booking->status_pembayaran === 'success') bg-green-100 text-green-700
                                    @elseif($booking->status_pembayaran === 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    @if($booking->status_pembayaran === 'success') Lunas
                                    @elseif($booking->status_pembayaran === 'pending') Pending
                                    @else Dibatalkan
                                    @endif
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Tanggal Kunjungan</p>
                                    <p class="font-semibold text-gray-800 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#3F51B5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d F Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Jumlah Tiket</p>
                                    <p class="font-semibold text-gray-800 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#3F51B5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                        {{ $booking->jumlah_tiket }} Tiket
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Metode Pembayaran</p>
                                    <p class="font-semibold text-gray-800">{{ ucfirst($booking->metode_pembayaran ?? 'Transfer Bank') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
                                    <p class="font-bold text-[#3F51B5] text-lg">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex gap-3 pt-4 border-t border-gray-200">
                                <a href="{{ route('destinasi.detail', $booking->destinasi->id_destinasi) }}" 
                                   class="px-6 py-2 border-2 border-[#3F51B5] text-[#3F51B5] rounded-lg font-semibold hover:bg-[#3F51B5] hover:text-white transition">
                                    Lihat Destinasi
                                </a>
                                @if($booking->status_pembayaran === 'success')
                                <button class="px-6 py-2 bg-[#3F51B5] text-white rounded-lg font-semibold hover:bg-[#2c3a7f] transition">
                                    Lihat E-Ticket
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-md p-12 text-center border border-gray-200">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Tiket</h3>
                <p class="text-gray-600 mb-6">Pesan tiket destinasi favorit kamu sekarang</p>
                <a href="{{ route('beranda') }}" 
                   class="inline-block px-8 py-3 bg-[#3F51B5] text-white rounded-lg font-semibold hover:bg-[#2c3a7f] transition">
                    Jelajahi Destinasi
                </a>
            </div>
        @endif
    </main>
@endsection
