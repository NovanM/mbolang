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
    
    /* Selected Destinations */
    .selection-row {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        margin-bottom: 1rem;
    }
    
    .selection-row::before {
        content: "";
        position: absolute;
        left: 8px;
        top: 30px;
        bottom: -12px;
        width: 2px;
        background: linear-gradient(180deg, rgba(63,81,181,0.35) 0%, rgba(63,81,181,0) 100%);
    }
    
    .selection-row:last-child::before,
    .selection-row.placeholder::before {
        display: none;
    }
    
    .timeline-dot {
        width: 18px;
        height: 18px;
        border-radius: 9999px;
        background: #3F51B5;
        box-shadow: 0 0 0 8px rgba(63, 81, 181, 0.18);
        margin-top: 1.25rem;
        flex-shrink: 0;
    }
    
    .selected-destination-card {
        border: 1px solid #D7DDF2;
        border-radius: 1.25rem;
        padding: 1.5rem;
        display: flex;
        gap: 1.25rem;
        align-items: center;
        background: #FFFFFF;
        width: 100%;
        box-shadow: 0 12px 24px rgba(28, 66, 140, 0.08);
    }
    
    .selected-destination-card img {
        width: 132px;
        height: 96px;
        object-fit: cover;
        border-radius: 0.9rem;
        flex-shrink: 0;
    }
    
    .selected-destination-card.placeholder {
        justify-content: center;
        text-align: center;
        color: #7B8AB7;
        font-weight: 500;
        background: #F7F9FF;
        border: 1px dashed #C4CDED;
        min-height: 110px;
    }
    
    .selected-destination-card .meta {
        color: #647098;
        font-size: 0.9rem;
    }
    
    .btn-disabled {
        opacity: 0.55;
        pointer-events: none;
    }
    
    .add-badge {
        position: absolute;
        bottom: 22px;
        right: 24px;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #1D2875;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FFFFFF;
        box-shadow: 0 10px 25px rgba(29, 40, 117, 0.22);
        flex-shrink: 0;
        pointer-events: none;
        transition: background 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }
    
    .destinasi-card {
        position: relative;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    
    .destinasi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 42px rgba(17, 31, 99, 0.18);
    }
    
    .destinasi-card.selected {
        border-color: #1D2875;
        box-shadow: 0 18px 46px rgba(17, 31, 99, 0.22);
    }
    
    .destinasi-card.selected .add-badge {
        background: #25AE62;
        box-shadow: 0 10px 26px rgba(37, 174, 98, 0.28);
    }
</style>
@endpush

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Pilih Rencana Perjalanan Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-[#203B8A] mb-8">{{ __('messages.choose_trip_plan') }}</h2>

            <!-- Selected Destinations Timeline -->
            <div id="selected-destinations" class="mb-8 space-y-4">
                <!-- Rendered dynamically -->
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <button type="button" onclick="scrollToDestinations()" class="bg-[#3F51B5] text-white px-10 py-3 rounded-xl font-semibold shadow-[0_12px_30px_rgba(63,81,181,0.25)] transition hover:bg-[#2c3a7f]">
                    {{ __('messages.add') }}
                </button>
                <button type="button" id="saveHeaderButton" onclick="saveItinerary()" class="bg-[#1D2875] text-white px-10 py-3 rounded-xl font-semibold shadow-[0_12px_30px_rgba(29,40,117,0.28)] transition hover:bg-[#131a5a] btn-disabled">
                    {{ __('messages.save') }}
                </button>
            </div>
        </div>

    <!-- Pilih Kategori Section -->
    <div id="destinationCatalog" class="mb-8">
            <h2 class="text-2xl font-bold text-[#3F51B5] mb-6">{{ __('messages.choose_category') }}</h2>
            
            <!-- Category Filter Buttons -->
            <div class="flex flex-wrap gap-3 mb-8 overflow-x-auto pb-2">
                <button type="button" onclick="filterCategory('all', this)" class="category-btn active px-6 py-2.5 rounded-full font-semibold bg-[#1D2875] text-white whitespace-nowrap transition hover:bg-[#131a5a]">{{ __('messages.all') }}</button>
                <button type="button" onclick="filterCategory('wisata', this)" class="category-btn px-6 py-2.5 rounded-full font-semibold border border-[#CAD0EC] text-[#203B8A] bg-white whitespace-nowrap transition hover:bg-[#f5f7ff]">{{ __('messages.category_wisata') }}</button>
                <button type="button" onclick="filterCategory('alam', this)" class="category-btn px-6 py-2.5 rounded-full font-semibold border border-[#CAD0EC] text-[#203B8A] bg-white whitespace-nowrap transition hover:bg-[#f5f7ff]">{{ __('messages.category_alam') }}</button>
                <button type="button" onclick="filterCategory('cafe', this)" class="category-btn px-6 py-2.5 rounded-full font-semibold border border-[#CAD0EC] text-[#203B8A] bg-white whitespace-nowrap transition hover:bg-[#f5f7ff]">{{ __('messages.category_cafe') }}</button>
                <button type="button" onclick="filterCategory('wahana', this)" class="category-btn px-6 py-2.5 rounded-full font-semibold border border-[#CAD0EC] text-[#203B8A] bg-white whitespace-nowrap transition hover:bg-[#f5f7ff]">{{ __('messages.category_wahana') }}</button>
                <button type="button" onclick="filterCategory('taman', this)" class="category-btn px-6 py-2.5 rounded-full font-semibold border border-[#CAD0EC] text-[#203B8A] bg-white whitespace-nowrap transition hover:bg-[#f5f7ff]">{{ __('messages.category_taman') }}</button>
                <button type="button" onclick="filterCategory('mall', this)" class="category-btn px-6 py-2.5 rounded-full font-semibold border border-[#CAD0EC] text-[#203B8A] bg-white whitespace-nowrap transition hover:bg-[#f5f7ff]">{{ __('messages.category_mall') }}</button>
            </div>
            
            <!-- Destinations Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach($destinasi as $dest)
                <div class="destinasi-card bg-white rounded-[28px] shadow-[0_14px_45px_rgba(17,31,99,0.12)] overflow-hidden transition-all duration-300 border border-[#E2E6F3] cursor-pointer" 
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
                    <div class="p-5 relative">
                        <!-- Title & Rating -->
                        <div class="mb-3">
                            <h3 class="text-lg font-semibold text-[#163072] mb-1">{{ $dest->nama_destinasi }}</h3>
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
                                <span class="text-sm font-semibold text-[#1D2875] ml-1">{{ number_format($dest->average_rating, 1) }}/5</span>
                            </div>
                        </div>

                        <!-- Location -->
                        <p class="text-sm text-[#4B5E95] mb-3 font-medium">{{ $dest->lokasi }}</p>

                        <!-- Category -->
                        <div class="flex items-center gap-2">
                            <span class="inline-flex px-4 py-1 bg-[#F0F3FF] text-[#1D2875] text-xs font-semibold rounded-full border border-[#D4DCF7]">
                                {{ $dest->kategori }}
                            </span>
                            <span class="add-badge">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Bottom Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <button type="button" onclick="history.back()" class="px-10 py-3 rounded-xl font-semibold border border-[#CAD0EC] text-[#1D2875] bg-white hover:bg-[#eff3ff] transition">
                    {{ __('messages.back') }}
                </button>
                <button type="button" id="saveFooterButton" onclick="saveItinerary()" class="px-10 py-3 rounded-xl font-semibold bg-[#1D2875] text-white hover:bg-[#131a5a] transition btn-disabled">
                    {{ __('messages.continue') }}
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
            <h2 class="text-2xl font-bold text-[#2C3E65] text-center mb-2">{!! nl2br(e(__('messages.plan_modal_question'))) !!}</h2>
            <p class="text-center text-gray-500 mb-6" id="modalDate">{{ \Carbon\Carbon::parse($itinerary->tanggal_mulai)->translatedFormat('d F, Y') }}</p>
            
            <!-- Time Inputs -->
            <div class="mb-8">
                <!-- Mulai Time -->
                <div class="mb-6">
                    <label class="block text-[#3F51B5] font-semibold mb-3 text-center">{{ __('messages.start') }}</label>
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
                <p class="text-center text-[#3F51B5] font-semibold">{{ __('messages.finish') }}</p>
            </div>
            
            <!-- Submit Button -->
            <button onclick="confirmAddDestination()" class="w-full bg-[#2C3E65] text-white py-4 rounded-xl font-semibold text-lg hover:bg-[#3d5078] transition">
                {{ __('messages.add') }}
            </button>
        </div>
    </div>

    <script>
    let selectedDestinationData = null;
    let addedDestinations = [];

    const planPlaceholder = @json(__('messages.plan_placeholder'));
    const planVisitTimeLabel = @json(__('messages.plan_visit_time'));
    const planMinWarning = @json(__('messages.plan_minimum_warning'));
    const planSaveSuccess = @json(__('messages.plan_save_success'));
    const planSaveFailedPrefix = @json(__('messages.plan_save_failed_prefix'));
    const planSaveError = @json(__('messages.plan_save_error'));
    const planRemoveDestinationLabel = @json(__('messages.plan_remove_destination'));
    const planUnknownError = @json(__('messages.unknown_error'));

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

        function filterCategory(category, target) {
            const cards = document.querySelectorAll('.destinasi-card');
            const buttons = document.querySelectorAll('.category-btn');
            
            // Update button states
            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-[#1D2875]', 'text-white');
                btn.classList.add('border', 'border-[#CAD0EC]', 'text-[#203B8A]', 'bg-white');
            });
            target.classList.add('active', 'bg-[#1D2875]', 'text-white');
            target.classList.remove('border', 'border-[#CAD0EC]', 'text-[#203B8A]', 'bg-white');
            
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
                image: element.querySelector('img')?.src || '{{ asset("images/placeholder.jpg") }}'
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

            markSelectedCards();
            
            // Update UI
            renderSelectedDestinations();
            
            // Close modal
            closeModal();
        }

        function renderSelectedDestinations() {
            const container = document.getElementById('selected-destinations');
            container.innerHTML = '';
            
            if (addedDestinations.length === 0) {
                const placeholder = document.createElement('div');
                placeholder.className = 'selection-row placeholder';
                placeholder.innerHTML = `
                    <div class="timeline-dot"></div>
                    <div class="selected-destination-card placeholder">
                        ${planPlaceholder}
                    </div>
                `;
                container.appendChild(placeholder);
                toggleSaveButtons(false);
                return;
            }

            addedDestinations.forEach((dest, index) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'selection-row';
                wrapper.innerHTML = `
                    <div class="timeline-dot"></div>
                    <div class="selected-destination-card flex-1">
                        <img src="${dest.image}" alt="${dest.name}">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-[#163072] mb-1">${dest.name}</h3>
                            <p class="meta mb-1">${planVisitTimeLabel} <strong>${dest.timeRange}</strong></p>
                            <p class="meta flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#1D2875]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                ${dest.phone}
                            </p>
                        </div>
                        <button onclick="removeDestination(${index})" class="text-[#EA5455] hover:text-[#c33838] p-2" aria-label="${planRemoveDestinationLabel}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-7 4h8a2 2 0 002-2v-7a2 2 0 00-2-2h-1.5l-.723-1.447A1 1 0 0014.862 4h-5.724a1 1 0 00-.915.553L7.5 6H6a2 2 0 00-2 2v7a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                `;
                container.appendChild(wrapper);
            });

            toggleSaveButtons(true);
        }

        function toggleSaveButtons(enabled) {
            const headerBtn = document.getElementById('saveHeaderButton');
            const footerBtn = document.getElementById('saveFooterButton');
            [headerBtn, footerBtn].forEach(btn => {
                if (!btn) return;
                btn.classList.toggle('btn-disabled', !enabled);
            });
        }

        function removeDestination(index) {
            addedDestinations.splice(index, 1);
            markSelectedCards();
            renderSelectedDestinations();
        }

        function markSelectedCards() {
            const cards = document.querySelectorAll('.destinasi-card');
            cards.forEach(card => {
                const isSelected = addedDestinations.some(dest => dest.id === card.dataset.id);
                card.classList.toggle('selected', isSelected);
            });
        }

        function saveItinerary() {
            if (addedDestinations.length === 0) {
                alert(planMinWarning);
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
                    alert(planSaveSuccess);
                    window.location.href = '{{ route("plan.list") }}';
                } else {
                    alert(planSaveFailedPrefix + ' ' + (data.message || planUnknownError));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(planSaveError);
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

        document.addEventListener('DOMContentLoaded', function() {
            renderSelectedDestinations();
            markSelectedCards();
        });

        function scrollToDestinations() {
            const section = document.getElementById('destinationCatalog');
            section?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    </script>
@endsection
