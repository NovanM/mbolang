@extends('layouts.app')

@section('title', $destinasi->nama_destinasi . ' - Mbolang')

@push('styles')
<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
@endpush

@section('content')
    <main class="bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg relative" role="alert">
                <strong class="font-bold">{{ __('messages.success') }}!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button onclick="this.parentElement.style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>{{ __('messages.close') }}</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </button>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Left Column - Image -->
                <div>
                    <div class="relative h-[500px] rounded-2xl overflow-hidden shadow-lg">
                        @if($destinasi->foto ?? false)
                        <img src="{{ asset($destinasi->foto) }}" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-[#3F51B5] to-[#1E3A8A] flex items-center justify-center">
                            <span class="text-white text-8xl font-bold">{{ substr($destinasi->nama_destinasi, 0, 1) }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Details -->
                <div class="space-y-7">
                <!-- Title & Wishlist -->
                <div class="flex justify-between items-start gap-6">
                    <h1 class="text-3xl font-extrabold text-[#2b4aa3] leading-tight">{{ $destinasi->nama_destinasi }}</h1>
                    
                    @auth
                    <form action="{{ route('favorit.toggle', $destinasi->id_destinasi) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-2 hover:bg-gray-100 rounded-full transition">
                            @if($isFavorited)
                            <svg class="w-7 h-7 text-red-500 fill-current" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                            </svg>
                            @else
                            <svg class="w-7 h-7 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            @endif
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="p-2 hover:bg-gray-100 rounded-full transition">
                        <svg class="w-7 h-7 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </a>
                    @endauth
                </div>

                <!-- Address -->
                <p class="text-gray-600 leading-relaxed">{{ $destinasi->lokasi }}</p>

                <!-- Tags -->
                        <div class="flex flex-wrap gap-3">
                    <span class="px-4 py-1.5 bg-white text-[#2b4aa3] text-sm font-semibold rounded-full border border-[#dcecff] shadow-sm">Edukasi</span>
                    <span class="px-4 py-1.5 bg-white text-[#2b4aa3] text-sm font-semibold rounded-full border border-[#dcecff] shadow-sm">{{ $destinasi->kategori }}</span>
                    <span class="px-4 py-1.5 bg-white text-[#2b4aa3] text-sm font-semibold rounded-full border border-[#dcecff] shadow-sm">Tempat santai</span>
                    <span class="px-4 py-1.5 bg-white text-[#2b4aa3] text-sm font-semibold rounded-full border border-[#dcecff] shadow-sm">Outdoor</span>
                    <span class="px-4 py-1.5 bg-white text-[#2b4aa3] text-sm font-semibold rounded-full border border-[#dcecff] shadow-sm">Seru dan Mengagumkan</span>
                </div>

                <!-- Rating & Reviews -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="flex items-center gap-1">
                            @for($i = 0; $i < 5; $i++)
                                @if($i < floor($destinasi->average_rating))
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
                        <span class="text-xl font-bold text-[#4a64d8]">{{ number_format($destinasi->average_rating, 1) }}/5</span>
                        <span class="text-sm font-medium text-gray-500">{{ $destinasi->ulasan->count() }} {{ __('messages.penilaian') }}</span>
                    </div>

                    @php
                        // lighter blue for pill action to match reference
                        $addToTripClasses = 'inline-flex items-center gap-2 px-4 py-2 border-2 border-[#2b4aa3] text-[#2b4aa3] rounded-full font-semibold transition hover:bg-[#2b4aa3] hover:text-white';
                    @endphp

                    @auth
                    <button onclick="showAddToPlanModal()" class="{{ $addToTripClasses }}">
                        <span>{{ __('messages.add_to_trip') }}</span>
                        <span class="flex items-center justify-center w-6 h-6 rounded-full border border-current">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5" />
                            </svg>
                        </span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="{{ $addToTripClasses }}">
                        <span>{{ __('messages.add_to_trip') }}</span>
                        <span class="flex items-center justify-center w-6 h-6 rounded-full border border-current">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5" />
                            </svg>
                        </span>
                    </a>
                    @endauth
                </div>

                <!-- Description -->
                <div>
                    <h3 class="font-bold text-xl text-[#2b4aa3] mb-3">{{ __('messages.about') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $destinasi->deskripsi }}</p>
                </div>

                <!-- Operating Hours -->
                <div class="rounded-2xl border border-[#dce9ff] bg-[#eef5ff] p-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white text-[#102347] shadow">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <h3 class="font-bold text-lg text-[#2b4aa3]">{{ __('messages.operating_hours') }}</h3>
                    </div>
                    <div class="space-y-2 text-sm text-[#102347]">
                        @php
                            $days = app()->getLocale() === 'id' 
                                ? ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                                : ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                            $today = now()->dayOfWeek;
                        @endphp
                        @foreach($days as $index => $day)
                        <div class="flex justify-between items-center rounded-xl px-4 py-2 {{ $index === $today ? 'bg-white shadow-sm font-semibold' : '' }}">
                            <span>{{ $day }}</span>
                            <span>{{ $destinasi->jam_buka }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Book Button -->
                <a href="{{ route('destinasi.pesan-tiket', $destinasi->id_destinasi) }}" class="w-full py-4 rounded-2xl border-2 border-[#102347] text-[#102347] font-semibold text-lg flex items-center justify-center gap-3 hover:bg-[#102347] hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-2.21 0-4 1.79-4 4 0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2 0-2.21-1.79-4-4-4zm0 8c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z" />
                    </svg>
                    {{ __('messages.book_ticket') }}
                </a>

                <!-- Reviews Section -->
                <div id="ulasan" class="border-t border-[#e5e7ff] pt-6">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="font-bold text-2xl text-[#102347]">{{ __('messages.ulasan') }}</h3>
                        <a href="{{ route('destinasi.ulasan', $destinasi->id_destinasi) }}" class="text-[#2b4aa3] text-sm font-semibold hover:underline">{{ __('messages.view_all') }}</a>
                    </div>

                    <!-- Reviews List -->
                    <div class="flex gap-5 overflow-x-auto pb-4 scrollbar-hide" style="scroll-behavior: smooth;">
                        @forelse($destinasi->ulasan as $ulasan)
                        <div class="bg-white border border-[#dce4ff] rounded-2xl p-5 min-w-[320px] flex-shrink-0 shadow-sm">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 bg-gradient-to-br from-[#00BCD4] to-[#0097A7] rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($ulasan->pengguna->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-[#102347]">{{ $ulasan->pengguna->nama }}</p>
                                        <p class="text-xs text-gray-500">by {{ strtolower(substr($ulasan->pengguna->nama, 0, strpos($ulasan->pengguna->nama, ' ') ?: strlen($ulasan->pengguna->nama))) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-sm font-bold text-[#102347]">{{ $ulasan->rating }}</span>
                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $ulasan->komentar }}</p>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-8 w-full">{{ __('messages.no_reviews_yet') }}</p>
                        @endforelse
                    </div>

                    <!-- Add Review Button -->
                    <a href="{{ route('destinasi.tambah-ulasan', $destinasi->id_destinasi) }}" class="w-full mt-6 bg-[#102347] text-white py-4 rounded-2xl font-semibold text-lg hover:bg-[#0c1b36] transition block text-center shadow-md">
                        {{ __('messages.add_review') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal: Add to Plan -->
        @auth
        <div id="addToPlanModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div id="addToPlanBackdrop" class="absolute inset-0 bg-black transition-opacity duration-300 ease-in-out opacity-0" onclick="closeAddToPlanModal()"></div>
            <div id="addToPlanContent" class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden shadow-2xl transform transition-all duration-300 ease-in-out scale-95 opacity-0">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-[#3F51B5]">{{ __('messages.plan_modal_title') }}</h2>
                    <button onclick="closeAddToPlanModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto max-h-[calc(80vh-180px)]">
                    @forelse($userItineraries as $itinerary)
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-6 mb-4 hover:border-[#3F51B5] transition cursor-pointer" onclick="selectPlan({{ $itinerary->id_itinerary }}, '{{ $itinerary->nama_itinerary }}', '{{ $itinerary->tanggal_mulai }}')">
                        <div class="flex items-start gap-4">
                            @php
                                $firstDestination = $itinerary->destinasiList->first();
                                $planImage = $firstDestination && $firstDestination->destinasi && $firstDestination->destinasi->foto
                                    ? asset($firstDestination->destinasi->foto)
                                    : null;
                            @endphp

                            @if($planImage)
                                <img src="{{ $planImage }}" alt="{{ $itinerary->nama_itinerary }}" class="w-20 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-16 rounded-lg flex items-center justify-center bg-gradient-to-br from-[#3F51B5] to-[#1E3A8A] text-white text-xl font-semibold">
                                    {{ strtoupper(substr($itinerary->nama_itinerary, 0, 1)) }}
                                </div>
                            @endif

                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-[#3F51B5] mb-2">{{ $itinerary->nama_itinerary }}</h3>
                                <div class="flex flex-wrap gap-2 mb-2">
                                    @forelse($itinerary->destinasiList->take(3) as $destItem)
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                            {{ $destItem->destinasi->nama_destinasi }}
                                        </span>
                                    @empty
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">{{ __('messages.plan_list_no_destinations') }}</span>
                                    @endforelse

                                    @if($itinerary->destinasiList->count() > 3)
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                            {{ __('messages.plan_modal_more_destinations', ['count' => $itinerary->destinasiList->count() - 3]) }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-600 text-sm">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($itinerary->tanggal_mulai)->translatedFormat('d F Y') }}
                                    @if($itinerary->tanggal_mulai !== $itinerary->tanggal_selesai)
                                        - {{ \Carbon\Carbon::parse($itinerary->tanggal_selesai)->translatedFormat('d F Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-lg font-semibold text-gray-700 mb-2">{{ __('messages.plan_list_empty_title') }}</p>
                        <p class="text-gray-600 mb-4">{{ __('messages.plan_list_empty_description') }}</p>
                        <a href="{{ route('itinerary.create') }}" class="inline-block px-6 py-2 bg-[#3F51B5] text-white rounded-lg font-semibold hover:bg-[#2c3a7f] transition">
                            {{ __('messages.plan_list_create_button') }}
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Modal: Set Time -->
        <div id="setTimeModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div id="setTimeBackdrop" class="absolute inset-0 bg-black transition-opacity duration-300 ease-in-out opacity-0" onclick="closeSetTimeModal()"></div>
            <div id="setTimeContent" class="relative bg-white rounded-2xl max-w-md w-full shadow-2xl transform transition-all duration-300 ease-in-out scale-95 opacity-0">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-[#3F51B5]" id="selectedPlanName"></h2>
                    <p class="text-gray-600 text-sm mt-1" id="selectedPlanDate"></p>
                </div>

                <form id="addDestinationForm" class="p-6">
                    @csrf
                    <input type="hidden" id="selectedItineraryId" name="itinerary_id">
                    <input type="hidden" name="destinasi_id" value="{{ $destinasi->id_destinasi }}">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                            <input type="time" name="jam_mulai" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3F51B5] focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Selesai</label>
                            <input type="time" name="jam_selesai" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#3F51B5] focus:outline-none">
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="button" onclick="closeSetTimeModal()" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-6 py-3 bg-[#3F51B5] text-white rounded-lg font-semibold hover:bg-[#2c3a7f] transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endauth
    </main>

    @auth
    <script>
        function showAddToPlanModal() {
            const modal = document.getElementById('addToPlanModal');
            const backdrop = document.getElementById('addToPlanBackdrop');
            const content = document.getElementById('addToPlanContent');
            
            modal.classList.remove('hidden');
            
            // Trigger animation
            setTimeout(() => {
                backdrop.style.opacity = '0.3';
                content.style.opacity = '1';
                content.style.transform = 'scale(1)';
            }, 10);
        }

        function closeAddToPlanModal() {
            const modal = document.getElementById('addToPlanModal');
            const backdrop = document.getElementById('addToPlanBackdrop');
            const content = document.getElementById('addToPlanContent');
            
            backdrop.style.opacity = '0';
            content.style.opacity = '0';
            content.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function selectPlan(itineraryId, planName, planDate) {
            document.getElementById('selectedItineraryId').value = itineraryId;
            document.getElementById('selectedPlanName').textContent = planName;
            document.getElementById('selectedPlanDate').textContent = 'Tanggal: ' + new Date(planDate).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            
            closeAddToPlanModal();
            
            // Small delay before showing next modal
            setTimeout(() => {
                showSetTimeModal();
            }, 400);
        }

        function showSetTimeModal() {
            const modal = document.getElementById('setTimeModal');
            const backdrop = document.getElementById('setTimeBackdrop');
            const content = document.getElementById('setTimeContent');
            
            modal.classList.remove('hidden');
            
            // Trigger animation
            setTimeout(() => {
                backdrop.style.opacity = '0.3';
                content.style.opacity = '1';
                content.style.transform = 'scale(1)';
            }, 10);
        }

        function closeSetTimeModal() {
            const modal = document.getElementById('setTimeModal');
            const backdrop = document.getElementById('setTimeBackdrop');
            const content = document.getElementById('setTimeContent');
            
            backdrop.style.opacity = '0';
            content.style.opacity = '0';
            content.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        document.getElementById('addDestinationForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const itineraryId = document.getElementById('selectedItineraryId').value;
            
            try {
                const response = await fetch(`/plan/${itineraryId}/add-destination-from-detail`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        destinasi_id: formData.get('destinasi_id'),
                        jam_mulai: formData.get('jam_mulai'),
                        jam_selesai: formData.get('jam_selesai'),
                    })
                });

                const data = await response.json();

                if (data.success) {
                    alert('Destinasi berhasil ditambahkan ke plan!');
                    closeSetTimeModal();
                    this.reset();
                } else {
                    alert('Gagal menambahkan destinasi: ' + (data.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan destinasi');
            }
        });

        // Close modal when clicking outside
        document.getElementById('addToPlanModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddToPlanModal();
            }
        });

        document.getElementById('setTimeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSetTimeModal();
            }
        });
    </script>
    @endauth
@endsection
