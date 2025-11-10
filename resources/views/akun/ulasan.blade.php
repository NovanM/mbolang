@extends('layouts.app')

@section('title', 'Ulasan Tempat - Mbolang')

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-[#3F51B5]">Ulasan Tempat</h1>
            <a href="{{ route('akun.index') }}" class="text-[#3F51B5] hover:text-[#2c3a7f] font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Ulasan List -->
        @if($ulasans->count() > 0)
            <div class="space-y-6">
                @foreach($ulasans as $ulasan)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-6 border border-gray-200">
                    <div class="flex gap-6">
                        <!-- Image -->
                        <img src="https://picsum.photos/seed/{{ $ulasan->destinasi->id_destinasi }}/150/150" 
                             alt="{{ $ulasan->destinasi->nama_destinasi }}" 
                             class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h3 class="text-xl font-bold text-[#3F51B5]">{{ $ulasan->destinasi->nama_destinasi }}</h3>
                                    <div class="flex items-center gap-1 mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                        <span class="text-gray-600 ml-2 text-sm">{{ $ulasan->rating }}/5</span>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $ulasan->created_at->format('d M Y') }}</span>
                            </div>
                            
                            <p class="text-gray-700 leading-relaxed mb-4">{{ $ulasan->komentar }}</p>
                            
                            <a href="{{ route('destinasi.detail', $ulasan->destinasi->id_destinasi) }}" 
                               class="inline-flex items-center gap-2 text-[#3F51B5] hover:text-[#2c3a7f] font-semibold">
                                Lihat Destinasi
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-md p-12 text-center border border-gray-200">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Ulasan</h3>
                <p class="text-gray-600 mb-6">Berikan ulasan untuk destinasi yang sudah kamu kunjungi</p>
                <a href="{{ route('beranda') }}" 
                   class="inline-block px-8 py-3 bg-[#3F51B5] text-white rounded-lg font-semibold hover:bg-[#2c3a7f] transition">
                    Jelajahi Destinasi
                </a>
            </div>
        @endif
    </main>
@endsection
