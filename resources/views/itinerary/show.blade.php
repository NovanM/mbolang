@extends('layouts.app')

@section('title', $itinerary->nama_itinerary . ' - Mbolang')

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg relative" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </button>
        </div>
        @endif

        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-[#3F51B5] mb-8">{{ $itinerary->nama_itinerary }}</h1>

        <!-- Destinations List -->
        <div class="space-y-6">
            @forelse($itinerary->destinasiList as $index => $itineraryDest)
            <div class="flex items-start gap-4">
                <!-- Number Bullet -->
                <div class="w-8 h-8 bg-[#3F51B5] rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0 mt-2">
                    {{ $index + 1 }}
                </div>

                <!-- Destination Card -->
                <div class="flex-1 bg-white rounded-2xl shadow-md p-6 border border-gray-200">
                    <div class="flex gap-6">
                        <!-- Image -->
                    @if($itineraryDest->destinasi->foto)
                    <img src="{{ asset($itineraryDest->destinasi->foto) }}" 
                        alt="{{ $itineraryDest->destinasi->nama_destinasi }}" 
                        class="w-32 h-24 object-cover rounded-lg flex-shrink-0">
                    @else
                    <div class="w-32 h-24 rounded-lg flex items-center justify-center bg-gradient-to-br from-[#3F51B5] to-[#1E3A8A] text-white text-2xl font-semibold flex-shrink-0">
                       {{ strtoupper(substr($itineraryDest->destinasi->nama_destinasi, 0, 1)) }}
                    </div>
                    @endif
                        
                        <!-- Info -->
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-[#3F51B5] mb-2">{{ $itineraryDest->destinasi->nama_destinasi }}</h3>
                            <p class="text-gray-600 mb-1">
                                Datang di jam <strong>{{ $itineraryDest->jam_kunjungan ?? '-' }}</strong>
                            </p>
                            <p class="text-gray-600 flex items-center gap-2 mb-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $itineraryDest->destinasi->no_telepon ?? 'Tidak ada nomor telepon' }}
                            </p>
                            <p class="text-gray-600 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657 5.657l4.243 4.243a8 8 0 1011.314-11.314l-4.243 4.243z" />
                                </svg>
                                {{ $itineraryDest->destinasi->lokasi ?? 'Lokasi belum tersedia' }}
                            </p>
                        </div>
                        <form action="{{ route('plan.destinations.destroy', [$itinerary->id_itinerary, $itineraryDest->id_itinerary_destinasi]) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-500 hover:text-red-600 border border-red-200 hover:border-red-400 rounded-lg transition" aria-label="{{ __('messages.plan_remove_destination') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="text-yellow-700 font-semibold text-lg mb-2">Belum ada destinasi</p>
                <p class="text-yellow-600">Anda belum menambahkan destinasi ke itinerary ini.</p>
            </div>
            @endforelse
        </div>

        <!-- Action Button -->
        <div class="mt-8">
            <a href="{{ route('plan.list') }}" class="px-8 py-3 rounded-lg font-semibold bg-[#3F51B5] text-white hover:bg-[#2c3a7f] transition inline-block">
                Kembali ke Plan
            </a>
        </div>
    </main>
@endsection
