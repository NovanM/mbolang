@extends('layouts.app')

@section('title', 'Ulasan Tempat - Mbolang')

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-[#3F51B5]">{{ __('messages.my_reviews') }}</h1>
            <a href="{{ route('akun.index') }}" class="text-[#3F51B5] hover:text-[#2c3a7f] font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('messages.back') }}
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-6 py-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <!-- Ulasan List -->
        @if($ulasans->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($ulasans as $ulasan)
                    @php
                        $dest = $ulasan->destinasi;
                    @endphp

                    @if(! $dest)
                        @continue
                    @endif

                    <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-6 border border-gray-200 h-full">
                        <div class="flex gap-6">
                            <!-- Image -->
                            @if($dest->foto)
                                <img src="{{ asset($dest->foto) }}"
                                     alt="{{ $dest->nama_destinasi }}"
                                     class="w-24 h-24 object-cover rounded-full flex-shrink-0">
                            @else
                                <div class="w-24 h-24 rounded-full flex items-center justify-center bg-gradient-to-br from-[#3F51B5] to-[#1E3A8A] text-white text-2xl font-semibold flex-shrink-0">
                                    {{ strtoupper(substr($dest->nama_destinasi, 0, 1)) }}
                                </div>
                            @endif

                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <h3 class="text-lg font-semibold text-[#3F51B5]">{{ $dest->nama_destinasi }}</h3>
                                        <div class="flex items-center gap-1 mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                            <span class="text-gray-600 ml-2 text-sm">{{ number_format($ulasan->rating, 1) }}/5</span>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $ulasan->created_at->diffForHumans() }}</span>
                                </div>

                                <p class="text-gray-700 leading-relaxed mb-4">{{ $ulasan->komentar }}</p>

                                <div class="flex flex-wrap items-center gap-3">
                                    <a href="{{ route('destinasi.detail', $dest->id_destinasi) }}"
                                       class="inline-flex items-center gap-2 text-[#3F51B5] hover:text-[#2c3a7f] font-semibold">
                                        {{ __('messages.plan_list_view_detail') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('akun.ulasan.edit', $ulasan->id_ulasan) }}"
                                       class="inline-flex items-center gap-2 text-[#1D2875] hover:text-[#0f1540] font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m4 0h2m-8 0H7m8 14H7a2 2 0 01-2-2V7a2 2 0 012-2h2m5.414 0L19 7.586a2 2 0 01.586 1.414V17a2 2 0 01-2 2h-2M10 11l2-2 5 5-2 2-3-3-2 2v-4z"/>
                                        </svg>
                                        {{ __('messages.edit_review') }}
                                    </a>
                                    <form action="{{ route('akun.ulasan.destroy', $ulasan->id_ulasan) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-semibold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            {{ __('messages.delete_review') }}
                                        </button>
                                    </form>
                                </div>
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
                <h3 class="text-xl font-bold text-gray-700 mb-2">{{ __('messages.no_reviews') }}</h3>
                <p class="text-gray-600 mb-6">{{ __('messages.review_prompt') }}</p>
                <a href="{{ route('beranda') }}" 
                   class="inline-block px-8 py-3 bg-[#3F51B5] text-white rounded-lg font-semibold hover:bg-[#2c3a7f] transition">
                    {{ __('messages.explore_destinations') }}
                </a>
            </div>
        @endif
    </main>
@endsection
