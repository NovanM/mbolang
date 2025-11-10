@extends('layouts.app')

@section('title', 'List Favorit - Mbolang')

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-[#3F51B5]">{{ __('messages.my_favorites') }}</h1>
            <a href="{{ route('akun.index') }}" class="text-[#3F51B5] hover:text-[#2c3a7f] font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('messages.back') }}
            </a>
        </div>

        <!-- Favorit List -->
        @if($favorits->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($favorits as $favorit)
                @php
                    $dest = $favorit->destinasi;
                @endphp

                @if(! $dest)
                    @continue
                @endif
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition overflow-hidden border border-gray-200">
                    <!-- Image -->
                    @if($dest->foto)
                    <img src="{{ asset($dest->foto) }}" 
                         alt="{{ $dest->nama_destinasi }}" 
                         class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gradient-to-br from-[#3F51B5] to-[#1E3A8A] flex items-center justify-center text-white text-4xl font-bold">
                        {{ strtoupper(substr($dest->nama_destinasi, 0, 1)) }}
                    </div>
                    @endif
                    
                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[#3F51B5] mb-2">{{ $dest->nama_destinasi }}</h3>
                        <p class="text-gray-600 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $dest->lokasi ?? __('messages.location_unavailable') }}
                        </p>
                        <p class="text-gray-600 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @if(! is_null($dest->average_rating))
                                {{ number_format($dest->average_rating, 1) }} / 5.0
                            @else
                                {{ __('messages.no_reviews') }}
                            @endif
                        </p>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('destinasi.detail', $dest->id_destinasi) }}" 
                                class="flex-1 px-4 py-2 bg-[#3F51B5] text-white rounded-lg font-semibold hover:bg-[#2c3a7f] transition text-center">
                                {{ __('messages.plan_list_view_detail') }}
                            </a>
                            <form action="{{ route('favorit.destroy', $favorit->id_favorit) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Hapus dari favorit?')"
                                        class="px-4 py-2 border-2 border-red-500 text-red-500 rounded-lg font-semibold hover:bg-red-50 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                    </path>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
                <div class="bg-white rounded-2xl shadow-md p-12 text-center border border-gray-200">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">{{ __('messages.no_favorites') }}</h3>
                    <p class="text-gray-600 mb-6">{{ __('messages.favorites_empty_description') }}</p>
                <a href="{{ route('beranda') }}" 
                   class="inline-block px-8 py-3 bg-[#3F51B5] text-white rounded-lg font-semibold hover:bg-[#2c3a7f] transition">
                        {{ __('messages.explore_destinations') }}
                </a>
            </div>
        @endif
    </main>
@endsection
