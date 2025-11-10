@extends('layouts.app')

@section('title', __('messages.plan_list_page_title'))

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-[#3F51B5] mb-8">{{ __('messages.plan_list_title') }}</h1>

        @if($itineraries->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('messages.plan_list_empty_title') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('messages.plan_list_empty_description') }}</p>
                <a href="{{ route('itinerary.create') }}" class="inline-block bg-[#3F51B5] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#2c3a7f] transition">
                    {{ __('messages.plan_list_create_button') }}
                </a>
            </div>
        @else
            <!-- Plans Grid -->
            <div class="space-y-6">
                @foreach($itineraries as $itinerary)
                @php
                    $destinations = $itinerary->destinasiList;
                    $destinationCount = $destinations->count();
                @endphp

                @if($destinationCount === 0)
                    @continue
                @endif

                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-6 border border-gray-200">
                    <div class="flex items-start gap-6">
                        <!-- Thumbnails -->
                        <div class="flex gap-2">
                            @foreach($destinations->take(2) as $destItem)
                                @if($destItem->destinasi->foto)
                                    <img src="{{ asset($destItem->destinasi->foto) }}"
                                         alt="{{ $destItem->destinasi->nama_destinasi }}"
                                         class="w-32 h-24 object-cover rounded-lg">
                                @else
                                    <div class="w-32 h-24 rounded-lg flex items-center justify-center bg-gradient-to-br from-[#3F51B5] to-[#1E3A8A] text-white text-3xl font-bold">
                                        {{ strtoupper(substr($destItem->destinasi->nama_destinasi, 0, 1)) }}
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Info -->
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-[#3F51B5] mb-2">{{ $itinerary->nama_itinerary }}</h3>
                            
                            <!-- Destination Pills -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($destinations->take(3) as $destItem)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm border border-gray-300">
                                    {{ $destItem->destinasi->nama_destinasi }}
                                </span>
                                @endforeach
                                
                                @if($destinationCount > 3)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm border border-gray-300">
                                    {{ __('messages.plan_list_more', ['count' => $destinationCount - 3]) }}
                                </span>
                                @endif
                            </div>

                            <!-- Date -->
                            <p class="text-gray-600 text-sm">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($itinerary->tanggal_mulai)->translatedFormat('d F Y') }}
                                @if($itinerary->tanggal_mulai != $itinerary->tanggal_selesai)
                                    - {{ \Carbon\Carbon::parse($itinerary->tanggal_selesai)->translatedFormat('d F Y') }}
                                @endif
                            </p>
                        </div>

                        <!-- Action Button -->
                        <div>
                            <a href="{{ route('itinerary.show', $itinerary->id_itinerary) }}" 
                               class="px-8 py-3 bg-[#3F51B5] text-white rounded-lg font-semibold hover:bg-[#2c3a7f] transition inline-block">
                                {{ __('messages.plan_list_view_detail') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </main>
@endsection
