@extends('layouts.app')

@section('title', 'Beranda - Mbolang')

@section('navbar-extra')
    <!-- Filter Icon -->
    <div class="flex items-center">
        <button onclick="toggleFilter()" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
        </button>
    </div>
@endsection

@section('content')
    <!-- Filter Modal -->
    <div id="filterModal" class="hidden fixed inset-0 z-50 flex items-start justify-center pt-20">
        <!-- Backdrop -->
        <div id="filterBackdrop" class="absolute inset-0 bg-black transition-opacity duration-300 ease-in-out opacity-0" onclick="toggleFilter()"></div>
        
        <!-- Modal Content -->
    <div id="filterContent" class="relative bg-white rounded-2xl shadow-xl w-full max-w-[92vw] sm:max-w-3xl lg:max-w-5xl xl:max-w-6xl mx-4 max-h-[85vh] overflow-y-auto transform transition-all duration-300 ease-in-out scale-95 opacity-0">
            <!-- Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center rounded-t-lg">
                <h2 class="text-2xl font-bold text-[#2b4aa3] tracking-tight leading-tight">{{ __('messages.choose_category') }}</h2>
                <button onclick="toggleFilter()" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Filter Content -->
            <div class="px-10 py-8">
                <form id="filterForm" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8 xl:gap-10 min-w-0">
                    <!-- Destinasi Wisata -->
                    <div class="min-w-0">
                        <h3 class="font-semibold text-[#2b4aa3] text-lg mb-4">{{ __('messages.tourist_destination') }}</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="kategori[]" value="Wisata alam" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.wisata_alam') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="kategori[]" value="Kuliner" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.kuliner') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="kategori[]" value="Wahana bermain" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.wahana_bermain') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="kategori[]" value="Museum" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.museum') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="kategori[]" value="Perpustakaan" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.perpustakaan') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="kategori[]" value="Lainnya" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.lainnya') }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Fasilitas -->
                    <div class="min-w-0">
                        <h3 class="font-semibold text-[#2b4aa3] text-lg mb-4">{{ __('messages.fasilitas') }}</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="fasilitas[]" value="Indoor" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.indoor') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="fasilitas[]" value="Outdoor" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.outdoor') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="fasilitas[]" value="Smooking area" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.smoking_area') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="fasilitas[]" value="AC" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.ac') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="fasilitas[]" value="Toilet" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.toilet') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="fasilitas[]" value="Mushola" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.mushola') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="fasilitas[]" value="Lainnya" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.lainnya') }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Keperluan -->
                    <div class="min-w-0">
                        <h3 class="font-semibold text-[#2b4aa3] text-lg mb-4">{{ __('messages.keperluan') }}</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="keperluan[]" value="Tempat santai" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.tempat_santai') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="keperluan[]" value="Meeting" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.meeting') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="keperluan[]" value="Keluarga" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.keluarga') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="keperluan[]" value="Teman" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.teman') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="keperluan[]" value="Date" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.date') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="keperluan[]" value="Nugas" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.nugas') }}</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="keperluan[]" value="Lainnya" class="w-4 h-4 text-[#3F51B5] border-gray-300 rounded focus:ring-[#3F51B5]">
                                <span class="text-sm text-gray-700">{{ __('messages.lainnya') }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div class="min-w-0">
                        <h3 class="font-semibold text-[#2b4aa3] text-lg mb-4">{{ __('messages.harga') }}</h3>
                        <div class="flex flex-col justify-center gap-3">
                            <div class="flex flex-wrap items-center gap-4">
                                <input 
                                    type="number" 
                                    name="harga_min" 
                                    placeholder="{{ __('messages.minimal') }}" 
                                    class="flex-1 min-w-[180px] max-w-xs px-5 py-3 border-2 border-[#4a64d8] rounded-full text-[#2b4aa3] placeholder-[#9aaae8] focus:ring-2 focus:ring-[#657af0] focus:border-transparent"
                                >
                                <span class="text-[#4a64d8] font-semibold text-lg flex-shrink-0">—</span>
                                <input 
                                    type="number" 
                                    name="harga_max" 
                                    placeholder="{{ __('messages.maksimal') }}" 
                                    class="flex-1 min-w-[180px] max-w-xs px-5 py-3 border-2 border-[#4a64d8] rounded-full text-[#2b4aa3] placeholder-[#9aaae8] focus:ring-2 focus:ring-[#657af0] focus:border-transparent"
                                >
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 rounded-b-lg">
                <div class="flex justify-end">
                    <button 
                        type="button" 
                        onclick="applyFilter()" 
                        class="w-60 py-3 bg-[#102347] text-white rounded-full font-semibold shadow-md hover:bg-[#0c1b36] transition-colors"
                    >
                        {{ __('messages.simpan') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Greeting -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-[#2b4aa3] mb-2">
                {!! __('messages.greeting', ['name' => '<span class="text-[#4a64d8]">' . (Auth::check() ? Auth::user()->nama : '') . '</span>']) !!}
            </h1>
        </div>

        <!-- Search Bar -->
        <div class="mb-8">
            <form action="{{ route('beranda') }}" method="GET" id="searchForm">
                <!-- Preserve existing filters -->
                @if(request('kategori'))
                    @foreach(request('kategori') as $kat)
                        <input type="hidden" name="kategori[]" value="{{ $kat }}">
                    @endforeach
                @endif
                @if(request('harga_min'))
                    <input type="hidden" name="harga_min" value="{{ request('harga_min') }}">
                @endif
                @if(request('harga_max'))
                    <input type="hidden" name="harga_max" value="{{ request('harga_max') }}">
                @endif
                
                <div class="relative max-w-full">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="searchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="{{ __('messages.search_placeholder') }}" 
                        class="w-full pl-14 pr-6 py-4 border border-[#9aaae8] rounded-full shadow-md text-[#2b4aa3] placeholder-[#a6b5f2] focus:ring-2 focus:ring-[#4a64d8] focus:border-[#657af0] outline-none transition"
                    >
                </div>
            </form>
        </div>

        <!-- Destinasi Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($destinasi as $item)
            <a href="{{ route('destinasi.detail', $item->id_destinasi) }}" class="bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border-2 border-[#657af0] block">
                <!-- Image -->
                <div class="relative h-56 bg-gray-200">
                    @if($item->foto)
                    <img src="{{ asset($item->foto) }}" alt="{{ $item->nama_destinasi }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#3F51B5] to-[#1E3A8A]">
                        <span class="text-white text-4xl font-bold">{{ substr($item->nama_destinasi, 0, 1) }}</span>
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-5">
                    <!-- Title & Rating -->
                    <div class="mb-3">
                        <h3 class="text-xl font-bold text-[#2b4aa3] mb-2">{{ $item->nama_destinasi }}</h3>
                        <div class="flex items-center gap-1">
                            @for($i = 0; $i < 5; $i++)
                                @if($i < floor($item->average_rating))
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                @endif
                            @endfor
                            <span class="text-base font-bold text-[#4a64d8] ml-1">{{ number_format($item->average_rating, 1) }}/5</span>
                        </div>
                    </div>

                    <!-- Location -->
                    <p class="text-base text-[#4a64d8] mb-2 font-medium">{{ $item->lokasi }}</p>

                    <!-- Category -->
                    <div class="flex items-center gap-2">
                        <span class="inline-block px-4 py-1.5 bg-white text-gray-800 text-sm font-medium rounded-lg border border-gray-300">
                            {{ $item->kategori }}
                        </span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada destinasi tersedia</p>
            </div>
            @endforelse
        </div>
    </main>

    <!-- Mobile Navigation (optional) -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-3">
        <div class="flex justify-around items-center">
            <a href="{{ route('beranda') }}" class="flex flex-col items-center text-[#3F51B5]">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                <span class="text-xs mt-1 font-medium">Beranda</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-xs mt-1">Plan</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs mt-1">Akun</span>
            </a>
        </div>
    </div>

    <script>
        function toggleFilter() {
            const modal = document.getElementById('filterModal');
            const backdrop = document.getElementById('filterBackdrop');
            const content = document.getElementById('filterContent');
            
            if (modal.classList.contains('hidden')) {
                // Show modal
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent body scroll
                
                // Trigger animation
                setTimeout(() => {
                    backdrop.style.opacity = '0.3';
                    content.style.opacity = '1';
                    content.style.transform = 'scale(1)';
                }, 10);
            } else {
                // Hide modal with animation
                backdrop.style.opacity = '0';
                content.style.opacity = '0';
                content.style.transform = 'scale(0.95)';
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = ''; // Restore body scroll
                }, 300);
            }
        }

        function applyFilter() {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            
            // Get all selected values
            const filters = {
                kategori: formData.getAll('kategori[]'),
                fasilitas: formData.getAll('fasilitas[]'),
                keperluan: formData.getAll('keperluan[]'),
                harga_min: formData.get('harga_min'),
                harga_max: formData.get('harga_max')
            };

            // Build query string
            const params = new URLSearchParams();
            
            // Preserve search query if exists
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput && searchInput.value) {
                params.append('search', searchInput.value);
            }
            
            filters.kategori.forEach(val => params.append('kategori[]', val));
            filters.fasilitas.forEach(val => params.append('fasilitas[]', val));
            filters.keperluan.forEach(val => params.append('keperluan[]', val));
            
            if (filters.harga_min) params.append('harga_min', filters.harga_min);
            if (filters.harga_max) params.append('harga_max', filters.harga_max);

            // Reload page with filters
            window.location.href = '{{ route("beranda") }}?' + params.toString();
        }

        // Search functionality
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchForm.submit();
                }
            });
        }

        // Close modal when pressing ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('filterModal');
                if (!modal.classList.contains('hidden')) {
                    toggleFilter();
                }
            }
        });
    </script>
@endsection
