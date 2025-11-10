@extends('layouts.app')

@section('title', 'Pilih Rencana Perjalanan - ' . $itinerary->nama_itinerary)

@section('body-class', 'bg-gray-50')

@push('styles')
<style>
    /* Modal Overlay */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 50;
        align-items: center;
        justify-content: center;
    }
    
    .modal-overlay.active {
        display: flex;
    }
    
    /* Modal Content */
    .modal-content {
        background: white;
        border-radius: 2rem;
        padding: 2.5rem;
        max-width: 500px;
        width: 90%;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    
    /* Time Input Styling */
    .time-input-group {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }
    
    .time-box {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .time-input {
        width: 60px;
        height: 70px;
        border: 2px solid #3F51B5;
        border-radius: 0.75rem;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 600;
        color: #2C3E65;
    }
    
    .time-separator {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2C3E65;
    }
    
    /* Selected Destination Card */
    .selected-destination-card {
        border: 1px solid #E5E7EB;
        border-radius: 0.75rem;
        padding: 1.25rem;
        display: flex;
        gap: 1rem;
        align-items: center;
        background: white;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .selected-destination-card img {
        width: 120px;
        height: 90px;
        object-fit: cover;
        border-radius: 0.5rem;
    }
    
    .number-bullet {
        width: 32px;
        height: 32px;
        background: #3F51B5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Pilih Rencana Perjalanan Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-[#3F51B5] mb-6">Pilih Rencana Perjalanan</h2>
            
            <!-- Selected Destinations List -->
            <div id="selected-destinations" class="mb-6">
                <!-- Selected destinations will be added here dynamically -->
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-4 mb-8">
                <button onclick="showAddDestinationModal()" class="bg-[#3F51B5] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#2c3a7f] transition">
                    Tambahkan
                </button>
                <button onclick="saveItinerary()" class="bg-[#2C3E65] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#3d5078] transition">
                    Simpan
                </button>
            </div>
        </div>

        <!-- Pilih Kategori Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#3F51B5] mb-6">Pilih Kategori</h2>
            
            <!-- Category Filter Buttons -->
            <div class="flex gap-3 mb-8 overflow-x-auto pb-2">
                <button onclick="filterCategory('all')" class="category-btn active px-6 py-2.5 rounded-lg font-semibold bg-[#3F51B5] text-white whitespace-nowrap transition hover:bg-[#2c3a7f]">Semua</button>
                <button onclick="filterCategory('wisata alam')" class="category-btn px-6 py-2.5 rounded-lg font-semibold border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 whitespace-nowrap transition">Wisata Alam</button>
                <button onclick="filterCategory('wisata kuliner')" class="category-btn px-6 py-2.5 rounded-lg font-semibold border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 whitespace-nowrap transition">Kuliner</button>
                <button onclick="filterCategory('wahana bermain')" class="category-btn px-6 py-2.5 rounded-lg font-semibold border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 whitespace-nowrap transition">Wahana</button>
                <button onclick="filterCategory('museum')" class="category-btn px-6 py-2.5 rounded-lg font-semibold border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 whitespace-nowrap transition">Museum</button>
                <button onclick="filterCategory('perpustakaan')" class="category-btn px-6 py-2.5 rounded-lg font-semibold border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 whitespace-nowrap transition">Perpustakaan</button>
            </div>
                <button onclick="filterCategory('wahana')" class="category-btn px-6 py-2.5 rounded-lg font-semibold border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 whitespace-nowrap transition">Wahana</button>
                <button onclick="filterCategory('taman')" class="category-btn px-6 py-2.5 rounded-lg font-semibold border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 whitespace-nowrap transition">Taman</button>
                <button onclick="filterCategory('mall')" class="category-btn px-6 py-2.5 rounded-lg font-semibold border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 whitespace-nowrap transition">Mall</button>
            </div>
            
            <!-- Destinations Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($destinasi as $dest)
                <div class="destinasi-card bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border-2 border-[#3F51B5] cursor-pointer" 
                     data-category="{{ strtolower($dest->kategori) }}"
                     data-id="{{ $dest->id_destinasi }}"
                     data-name="{{ $dest->nama_destinasi }}"
                     data-location="{{ $dest->lokasi }}"
                     data-hours="{{ $dest->jam_operasional ?? '10.00 - 13.00 WIB' }}"
                     data-phone="{{ $dest->no_telepon ?? '0821-0000-1209' }}"
                     onclick="selectDestination(this)">
                    <!-- Image -->
                    <div class="relative h-56 bg-gray-200">
                        @if($dest->foto)
                        <img src="{{ asset($dest->foto) }}" alt="{{ $dest->nama_destinasi }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#3F51B5] to-[#1E3A8A]">
                            <span class="text-white text-4xl font-bold">{{ substr($dest->nama_destinasi, 0, 1) }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div class="p-5">
                        <!-- Title & Rating -->
                        <div class="mb-3">
                            <h3 class="text-xl font-bold text-[#3F51B5] mb-2">{{ $dest->nama_destinasi }}</h3>
                            <div class="flex items-center gap-1">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < floor($dest->average_rating))
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    @endif
                                @endfor
                                <span class="text-base font-bold text-gray-700 ml-1">{{ number_format($dest->average_rating, 1) }}/5</span>
                            </div>
                        </div>

                        <!-- Location -->
                        <p class="text-base text-[#3F51B5] mb-2 font-medium">{{ $dest->lokasi }}</p>

                        <!-- Category -->
                        <div class="flex items-center gap-2">
                            <span class="inline-block px-4 py-1.5 bg-white text-gray-800 text-sm font-medium rounded-lg border border-gray-300">
                                {{ $dest->kategori }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Bottom Action Buttons -->
            <div class="flex justify-between gap-4">
                <button onclick="history.back()" class="px-10 py-3 rounded-lg font-semibold border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition">
                    Kembali
                </button>
                <button onclick="saveItinerary()" class="px-10 py-3 rounded-lg font-semibold bg-[#2C3E65] text-white hover:bg-[#3d5078] transition">
                    Lanjutkan
                </button>
            </div>
        </div>
    </main>

    <!-- Time Selection Modal -->
    <div class="modal-overlay" id="timeModal">
        <div class="modal-content">
            <!-- Back Button -->
            <button onclick="closeModal()" class="absolute top-6 left-6 text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <!-- Modal Title -->
            <h2 class="text-2xl font-bold text-[#2C3E65] text-center mb-2">Ingin Menambahkan<br>ke Perjalanan ?</h2>
            <p class="text-center text-gray-500 mb-6" id="modalDate">14 Februari, 2025</p>
            
            <!-- Time Inputs -->
            <div class="mb-8">
                <!-- Mulai Time -->
                <div class="mb-6">
                    <label class="block text-[#3F51B5] font-semibold mb-3 text-center">Mulai</label>
                    <div class="time-input-group justify-center">
                        <div class="time-box">
                            <input type="number" min="0" max="23" value="09" class="time-input" id="startHour" maxlength="2">
                            <input type="number" min="0" max="59" value="00" class="time-input" id="startMinute" maxlength="2">
                        </div>
                        <span class="time-separator">—</span>
                        <div class="time-box">
                            <input type="number" min="0" max="23" value="11" class="time-input" id="endHour" maxlength="2">
                            <input type="number" min="0" max="59" value="00" class="time-input" id="endMinute" maxlength="2">
                        </div>
                    </div>
                </div>
                
                <!-- Selesai Label -->
                <p class="text-center text-[#3F51B5] font-semibold">Selesai</p>
            </div>
            
            <!-- Submit Button -->
            <button onclick="confirmAddDestination()" class="w-full bg-[#2C3E65] text-white py-4 rounded-xl font-semibold text-lg hover:bg-[#3d5078] transition">
                Tambahkan
            </button>
        </div>
    </div>

    <script>
        let selectedDestinationData = null;
        let addedDestinations = [];

        // Load existing destinations from itinerary
        @if($itinerary->destinasiList->count() > 0)
            addedDestinations = [
                @foreach($itinerary->destinasiList as $item)
                {
                    id: '{{ $item->destinasi->id_destinasi }}',
                    name: '{{ $item->destinasi->nama_destinasi }}',
                    location: '{{ $item->destinasi->lokasi }}',
                    hours: '{{ $item->jam_mulai }} - {{ $item->jam_selesai }}',
                    phone: '{{ $item->destinasi->no_telepon ?? "0821-0000-1209" }}',
                    image: '{{ $item->destinasi->foto ? asset($item->destinasi->foto) : asset("images/placeholder.jpg") }}',
                    timeRange: '{{ date("H.i", strtotime($item->jam_mulai)) }} - {{ date("H.i", strtotime($item->jam_selesai)) }} WIB'
                },
                @endforeach
            ];
            
            // Render existing destinations on page load
            document.addEventListener('DOMContentLoaded', function() {
                renderSelectedDestinations();
            });
        @endif

        function filterCategory(category) {
            const cards = document.querySelectorAll('.destinasi-card');
            const buttons = document.querySelectorAll('.category-btn');
            
            // Update button states
            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-[#3F51B5]', 'text-white');
                btn.classList.add('border-2', 'border-gray-300', 'text-gray-700', 'bg-white');
            });
            event.target.classList.add('active', 'bg-[#3F51B5]', 'text-white');
            event.target.classList.remove('border-2', 'border-gray-300', 'text-gray-700', 'bg-white');
            
            // Filter cards
            cards.forEach(card => {
                if (category === 'all' || card.dataset.category.toLowerCase().includes(category.toLowerCase())) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function selectDestination(element) {
            selectedDestinationData = {
                id: element.dataset.id,
                name: element.dataset.name,
                location: element.dataset.location,
                hours: element.dataset.hours,
                phone: element.dataset.phone,
                image: element.querySelector('img').src
            };
            
            showTimeModal();
        }

        function showTimeModal() {
            const modal = document.getElementById('timeModal');
            modal.classList.add('active');
            
            // Set date from itinerary
            const date = '{{ \Carbon\Carbon::parse($itinerary->tanggal_mulai)->format("d F, Y") }}';
            document.getElementById('modalDate').textContent = date;
        }

        function closeModal() {
            const modal = document.getElementById('timeModal');
            modal.classList.remove('active');
            selectedDestinationData = null;
        }

        function confirmAddDestination() {
            if (!selectedDestinationData) return;
            
            const startHour = document.getElementById('startHour').value.padStart(2, '0');
            const startMinute = document.getElementById('startMinute').value.padStart(2, '0');
            const endHour = document.getElementById('endHour').value.padStart(2, '0');
            const endMinute = document.getElementById('endMinute').value.padStart(2, '0');
            
            const timeRange = `${startHour}.${startMinute} - ${endHour}.${endMinute} WIB`;
            
            // Add to list
            addedDestinations.push({
                ...selectedDestinationData,
                timeRange: timeRange
            });
            
            // Update UI
            renderSelectedDestinations();
            
            // Close modal
            closeModal();
        }

        function renderSelectedDestinations() {
            const container = document.getElementById('selected-destinations');
            container.innerHTML = '';
            
            addedDestinations.forEach((dest, index) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'flex items-start gap-4 mb-4';
                wrapper.innerHTML = `
                    <div class="number-bullet mt-2">
                        ${index + 1}
                    </div>
                    <div class="selected-destination-card flex-1">
                        <img src="${dest.image}" alt="${dest.name}">
                        <div class="flex-1">
                            <h3 class="font-bold text-[#3F51B5] mb-1">${dest.name}</h3>
                            <p class="text-sm text-gray-600 mb-1">Datang di jam <strong>${dest.timeRange}</strong></p>
                            <p class="text-sm text-gray-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                ${dest.phone}
                            </p>
                        </div>
                        <button onclick="removeDestination(${index})" class="text-[#3F51B5] hover:text-[#2c3a7f] p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                `;
                container.appendChild(wrapper);
            });
        }

        function removeDestination(index) {
            addedDestinations.splice(index, 1);
            renderSelectedDestinations();
        }

        function saveItinerary() {
            if (addedDestinations.length === 0) {
                alert('Silakan tambahkan minimal 1 destinasi');
                return;
            }
            
            // Prepare data
            const destinations = addedDestinations.map(dest => ({
                destinasi_id: dest.id,
                jam_mulai: dest.timeRange.split(' - ')[0].replace('.', ':'),
                jam_selesai: dest.timeRange.split(' - ')[1].replace(' WIB', '').replace('.', ':'),
                phone: dest.phone
            }));
            
            // Save to backend
            fetch('{{ route("plan.save", $itinerary->id_itinerary) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ destinations })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Perjalanan berhasil disimpan!');
                    window.location.href = '{{ route("plan.list") }}';
                } else {
                    alert('Gagal menyimpan: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan');
            });
        }

        // Auto format time inputs
        document.querySelectorAll('.time-input').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length >= 2) {
                    this.value = this.value.slice(0, 2);
                }
            });
        });

        // Close modal on overlay click
        document.getElementById('timeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
@endsection
