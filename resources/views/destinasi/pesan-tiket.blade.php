@extends('layouts.app')

@section('title', __('messages.book_ticket') . ' - ' . $destinasi->nama_destinasi)

@section('body-class', 'bg-white')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left Side - Image -->
            <div>
                <div class="relative w-full rounded-[28px] overflow-hidden shadow-[0_24px_45px_rgba(16,35,71,0.18)]">
                    @if($destinasi->foto)
                    <img src="{{ asset($destinasi->foto) }}" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-[540px] object-cover">
                    @else
                    <div class="w-full h-[540px] flex items-center justify-center bg-gradient-to-br from-[#3F51B5] to-[#1E3A8A]">
                        <span class="text-white text-7xl font-bold">{{ substr($destinasi->nama_destinasi, 0, 1) }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Side - Booking Form -->
            <div class="flex flex-col justify-between">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-[#2b4aa3] leading-tight mb-3">{{ $destinasi->nama_destinasi }}</h1>
                    <p class="text-[#7a87a6]">{{ $destinasi->lokasi }}</p>
                </div>

                <!-- Detail Pesanan -->
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-[#2b4aa3] mb-5">{{ __('messages.order_details') }}</h2>
                    
                    <!-- Tanggal Kunjungan -->
                    <div class="mb-8">
                        <span class="block text-sm font-semibold text-[#7a87a6] mb-4">{{ __('messages.visit_date') }}</span>
                        <div class="flex flex-wrap gap-3">
                            @php
                                $today = now();
                                $dateOptions = [
                                    ['label' => __('messages.today'), 'date' => $today->copy()],
                                    ['label' => __('messages.tomorrow'), 'date' => $today->copy()->addDay()],
                                    ['label' => $today->copy()->addDays(2)->locale(app()->getLocale())->isoFormat('ddd'), 'date' => $today->copy()->addDays(2)],
                                    ['label' => $today->copy()->addDays(3)->locale(app()->getLocale())->isoFormat('ddd'), 'date' => $today->copy()->addDays(3)],
                                    ['label' => $today->copy()->addDays(4)->locale(app()->getLocale())->isoFormat('ddd'), 'date' => $today->copy()->addDays(4)],
                                    ['label' => $today->copy()->addDays(5)->locale(app()->getLocale())->isoFormat('ddd'), 'date' => $today->copy()->addDays(5)],
                                ];
                            @endphp
                            @foreach($dateOptions as $index => $option)
                            <button 
                                type="button" 
                                class="date-btn inline-flex flex-col justify-center items-center gap-1 px-5 py-3 rounded-[16px] border-2 text-sm font-semibold transition-all {{ $index === 0 ? 'border-[#102347] text-white bg-[#102347]' : 'border-[#102347] text-[#102347] bg-white hover:bg-[#f5f7ff]' }}"
                                data-date="{{ $option['date']->format('Y-m-d') }}"
                            >
                                <span>{{ $option['label'] }}</span>
                                <span class="text-xs font-normal opacity-80">{{ $option['date']->locale(app()->getLocale())->translatedFormat('d M Y') }}</span>
                            </button>
                            @endforeach
                            <button 
                                type="button" 
                                id="customDateBtn"
                                onclick="document.getElementById('customDateInput').showPicker()"
                                class="date-btn inline-flex flex-col justify-center items-center gap-1 px-5 py-3 rounded-[16px] border-2 border-[#102347] text-[#102347] bg-white hover:bg-[#f5f7ff] transition cursor-pointer"
                            >
                                <span>{{ __('messages.pick_date') }}</span>
                                <span class="text-xs font-normal opacity-80">{{ __('messages.custom_label') }}</span>
                            </button>
                        </div>
                        <input type="date" id="customDateInput" style="position: absolute; opacity: 0; pointer-events: none;" min="{{ now()->format('Y-m-d') }}">
                    </div>

                    <!-- Jumlah Tiket -->
                    <div class="mb-8">
                        <span class="block text-sm font-semibold text-[#7a87a6] mb-4">{{ __('messages.ticket_quantity') }}</span>
                        <div class="rounded-[18px] border border-[#d7dcf0] bg-white px-6 py-5 flex items-center justify-between shadow-[0_6px_16px_rgba(16,35,71,0.08)]">
                            <div>
                                <p class="font-semibold text-[#102347] text-lg">{{ __('messages.pax') }}</p>
                                <p class="text-sm text-[#ff5a5f]">IDR {{ number_format($destinasi->harga_tiket, 0, ',', '.') }} <span class="text-[#9aa6c5]">{{ __('messages.per_pax') }}</span></p>
                            </div>
                            <div class="flex items-center gap-5">
                                <button type="button" onclick="decreaseQuantity()" class="w-9 h-9 flex items-center justify-center border-2 border-[#102347] text-[#102347] rounded-full hover:bg-[#102347] hover:text-white transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <span id="quantity" class="text-xl font-bold text-[#102347] w-6 text-center">5</span>
                                <button type="button" onclick="increaseQuantity()" class="w-9 h-9 flex items-center justify-center border-2 border-[#102347] text-[#102347] rounded-full hover:bg-[#102347] hover:text-white transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="mb-10">
                        <span class="block text-sm font-semibold text-[#7a87a6] mb-2">{{ __('messages.total') }}:</span>
                        <p id="total" class="text-2xl font-extrabold text-[#102347]">IDR {{ number_format($destinasi->harga_tiket * 5, 0, ',', '.') }}</p>
                    </div>

                    <!-- Beli Tiket Button -->
                    <button type="button" onclick="goToCheckout()" class="w-full py-4 rounded-full bg-[#102347] text-white font-semibold text-lg shadow-[0_10px_20px_rgba(16,35,71,0.2)] hover:bg-[#0c1b36] transition">
                        {{ __('messages.buy_ticket') }}
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        let quantity = 5;
        const pricePerPax = {{ $destinasi->harga_tiket }};
        let selectedDate = '{{ now()->format("Y-m-d") }}';
        const customPrimaryLabel = @json(__('messages.pick_date'));
    const customSecondaryLabel = @json(__('messages.custom_label'));
        const locale = @json(app()->getLocale() === 'en' ? 'en-US' : 'id-ID');

        const customBtn = document.getElementById('customDateBtn');

        // Handle custom date selection
        document.getElementById('customDateInput').addEventListener('change', function(e) {
            const selectedCustomDate = e.target.value;
            if (selectedCustomDate) {
                selectedDate = selectedCustomDate;
                
                // Update button to show selected date
                const dateObj = new Date(selectedCustomDate);
                const options = { day: 'numeric', month: 'short', year: 'numeric' };
                const formattedDate = dateObj.toLocaleDateString(locale, options);
                
                customBtn.innerHTML = `
                    <span>${customPrimaryLabel}</span>
                    <span class="text-xs font-normal opacity-80">${formattedDate}</span>
                `;
                
                // Update selection styling
                document.querySelectorAll('.date-btn').forEach(btn => {
                    btn.classList.remove('bg-[#102347]', 'text-white');
                    btn.classList.add('bg-white', 'text-[#102347]');
                });
                customBtn.classList.remove('bg-white', 'text-[#102347]');
                customBtn.classList.add('bg-[#102347]', 'text-white');
            }
        });

        function goToCheckout() {
            const url = `{{ route('destinasi.checkout', $destinasi->id_destinasi) }}?quantity=${quantity}&date=${selectedDate}`;
            window.location.href = url;
        }

        function updateTotal() {
            const total = quantity * pricePerPax;
            document.getElementById('quantity').textContent = quantity;
            document.getElementById('total').textContent = 'IDR ' + total.toLocaleString(locale);
        }

        function increaseQuantity() {
            quantity++;
            updateTotal();
        }

        function decreaseQuantity() {
            if (quantity > 1) {
                quantity--;
                updateTotal();
            }
        }

        // Date button selection
        document.querySelectorAll('.date-btn:not(#customDateBtn)').forEach(button => {
            button.addEventListener('click', function() {
                // Update selected date from data attribute
                selectedDate = this.getAttribute('data-date');
                
                // Update styling
                document.querySelectorAll('.date-btn').forEach(btn => {
                    btn.classList.remove('bg-[#102347]', 'text-white');
                    btn.classList.add('bg-white', 'text-[#102347]');
                });
                this.classList.remove('bg-white', 'text-[#102347]');
                this.classList.add('bg-[#102347]', 'text-white');

                // Reset custom button label when a preset date is selected
                customBtn.innerHTML = `
                    <span>${customPrimaryLabel}</span>
                    <span class="text-xs font-normal opacity-80">${customSecondaryLabel}</span>
                `;
                customBtn.classList.remove('bg-[#102347]', 'text-white');
                customBtn.classList.add('bg-white', 'text-[#102347]');
            });
        });
    </script>
@endsection
