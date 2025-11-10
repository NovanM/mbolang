@extends('layouts.app')

@section('title', 'Ulasan ' . $destinasi->nama_destinasi . ' - Mbolang')

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-[#3F51B5] mb-2">{{ $destinasi->nama_destinasi }}</h1>
                    <p class="text-gray-600 text-lg">{{ $destinasi->lokasi }}</p>
                </div>
                <a href="{{ route('destinasi.tambah-ulasan', $destinasi->id_destinasi) }}" class="bg-[#1E3A8A] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#2c5aa0] transition inline-block">
                    Tambahkan Ulasan
                </a>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($destinasi->average_rating))
                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        @else
                        <svg class="w-6 h-6 text-gray-300 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        @endif
                    @endfor
                </div>
                <span class="font-bold text-gray-900 text-xl">{{ number_format($destinasi->average_rating, 0) }}/5</span>
                <span class="text-gray-600 text-lg border-l border-gray-300 pl-4">{{ $destinasi->ulasan->count() }} Penilaian</span>
            </div>
        </div>

        <!-- Reviews Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($destinasi->ulasan as $ulasan)
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-[#00BCD4] to-[#0097A7] rounded-full flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                        {{ substr($ulasan->pengguna->nama, 0, 1) }}
                    </div>
                    <p class="font-semibold text-gray-900 text-lg">{{ $ulasan->pengguna->nama }}</p>
                </div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($ulasan->rating))
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($ulasan->tanggal_ulasan)->locale('id')->diffForHumans() }}</span>
                </div>
                <p class="text-gray-700 leading-relaxed">{{ $ulasan->komentar }}</p>
            </div>
            @empty
            <div class="col-span-2 bg-white rounded-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada ulasan</p>
                <p class="text-gray-400 text-sm mt-1">Jadilah yang pertama memberikan ulasan!</p>
            </div>
            @endforelse
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('destinasi.detail', $destinasi->id_destinasi) }}" class="inline-flex items-center gap-2 text-[#3F51B5] font-medium hover:underline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Detail Destinasi
            </a>
        </div>
    </main>
@endsection
