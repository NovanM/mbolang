@extends('layouts.app')

@section('title', 'Pesan Tiket - ' . $destinasi->nama_destinasi)

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Side - Image -->
            <div>
                <img src="https://picsum.photos/seed/{{ $destinasi->id_destinasi }}/600/400" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-[600px] object-cover rounded-2xl shadow-lg">
            </div>

            <!-- Right Side - Booking Form -->
            <div>
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-[#3F51B5] mb-2">{{ $destinasi->nama_destinasi }}</h1>
                    <p class="text-gray-600">{{ $destinasi->lokasi }}</p>
                </div>

                <!-- Detail Pesanan -->
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-[#3F51B5] mb-4">Detail Pesanan</h2>
                    
                    <!-- Tanggal Kunjungan -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Tanggal Kunjungan</label>
                        <div class="grid grid-cols-4 gap-2">
                            <button type="button" class="date-btn px-4 py-3 border-2 border-[#3F51B5] bg-[#3F51B5] text-white rounded-lg text-sm font-medium hover:bg-[#2c3e8f] transition" data-date="{{ now()->format('Y-m-d') }}">
                                <div>Hari Ini</div>
                                <div class="text-xs">{{ now()->format('d M Y') }}</div>
                            </button>
                            <button type="button" class="date-btn px-4 py-3 border-2 border-gray-300 bg-white text-gray-700 rounded-lg text-sm font-medium hover:border-[#3F51B5] transition" data-date="{{ now()->addDay()->format('Y-m-d') }}">
                                <div>Besok</div>
                                <div class="text-xs">{{ now()->addDay()->format('d M Y') }}</div>
                            </button>
                            <button type="button" class="date-btn px-4 py-3 border-2 border-gray-300 bg-white text-gray-700 rounded-lg text-sm font-medium hover:border-[#3F51B5] transition" data-date="{{ now()->addDays(2)->format('Y-m-d') }}">
                                <div>{{ now()->addDays(2)->locale('id')->isoFormat('ddd') }}</div>
                                <div class="text-xs">{{ now()->addDays(2)->format('d M Y') }}</div>
                            </button>
                            <button type="button" class="date-btn px-4 py-3 border-2 border-gray-300 bg-white text-gray-700 rounded-lg text-sm font-medium hover:border-[#3F51B5] transition" data-date="{{ now()->addDays(3)->format('Y-m-d') }}">
                                <div>{{ now()->addDays(3)->locale('id')->isoFormat('ddd') }}</div>
                                <div class="text-xs">{{ now()->addDays(3)->format('d M Y') }}</div>
                            </button>
                            <button type="button" class="date-btn px-4 py-3 border-2 border-gray-300 bg-white text-gray-700 rounded-lg text-sm font-medium hover:border-[#3F51B5] transition" data-date="{{ now()->addDays(4)->format('Y-m-d') }}">
                                <div>{{ now()->addDays(4)->locale('id')->isoFormat('ddd') }}</div>
                                <div class="text-xs">{{ now()->addDays(4)->format('d M Y') }}</div>
                            </button>
                            <button type="button" class="date-btn px-4 py-3 border-2 border-gray-300 bg-white text-gray-700 rounded-lg text-sm font-medium hover:border-[#3F51B5] transition" data-date="{{ now()->addDays(5)->format('Y-m-d') }}">
                                <div>{{ now()->addDays(5)->locale('id')->isoFormat('ddd') }}</div>
                                <div class="text-xs">{{ now()->addDays(5)->format('d M Y') }}</div>
                            </button>
                            <button type="button" id="customDateBtn" onclick="document.getElementById('customDateInput').showPicker()" class="date-btn px-4 py-3 border-2 border-gray-300 bg-white text-gray-700 rounded-lg text-sm font-medium hover:border-[#3F51B5] transition cursor-pointer">
                                <div>Tanggal</div>
                                <div class="text-xs">Lainnya</div>
                            </button>
                        </div>
                        <input type="date" id="customDateInput" style="position: absolute; opacity: 0; pointer-events: none;" min="{{ now()->format('Y-m-d') }}">
                    </div>

                    <!-- Jumlah Tiket -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Jumlah Tiket</label>
                        <div class="bg-white border border-gray-300 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">Pax</p>
                                    <p class="text-sm text-red-600">IDR {{ number_format($destinasi->harga_tiket, 0, ',', '.') }} <span class="text-gray-500">/pax</span></p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <button type="button" onclick="decreaseQuantity()" class="w-8 h-8 flex items-center justify-center border-2 border-gray-300 rounded-full hover:border-[#3F51B5] hover:text-[#3F51B5] transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span id="quantity" class="text-lg font-bold text-gray-900 w-8 text-center">5</span>
                                    <button type="button" onclick="increaseQuantity()" class="w-8 h-8 flex items-center justify-center border-2 border-gray-300 rounded-full hover:border-[#3F51B5] hover:text-[#3F51B5] transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 font-medium">Total:</span>
                            <span id="total" class="text-2xl font-bold text-gray-900">IDR {{ number_format($destinasi->harga_tiket * 5, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Beli Tiket Button -->
                    <button type="button" onclick="goToCheckout()" class="w-full bg-[#1E3A8A] text-white py-4 rounded-lg font-semibold text-lg hover:bg-[#2c5aa0] transition shadow-lg">
                        Beli Tiket
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        let quantity = 5;
        const pricePerPax = {{ $destinasi->harga_tiket }};
        let selectedDate = '{{ now()->format("Y-m-d") }}';

        // Handle custom date selection
        document.getElementById('customDateInput').addEventListener('change', function(e) {
            const selectedCustomDate = e.target.value;
            if (selectedCustomDate) {
                selectedDate = selectedCustomDate;
                
                // Update button to show selected date
                const customBtn = document.getElementById('customDateBtn');
                const dateObj = new Date(selectedCustomDate);
                const options = { day: 'numeric', month: 'short', year: 'numeric' };
                const formattedDate = dateObj.toLocaleDateString('id-ID', options);
                
                customBtn.innerHTML = `
                    <div>Custom</div>
                    <div class="text-xs">${formattedDate}</div>
                `;
                
                // Update selection styling
                document.querySelectorAll('.date-btn').forEach(btn => {
                    btn.classList.remove('bg-[#3F51B5]', 'text-white', 'border-[#3F51B5]');
                    btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
                });
                customBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                customBtn.classList.add('bg-[#3F51B5]', 'text-white', 'border-[#3F51B5]');
            }
        });

        function goToCheckout() {
            const url = `{{ route('destinasi.checkout', $destinasi->id_destinasi) }}?quantity=${quantity}&date=${selectedDate}`;
            window.location.href = url;
        }

        function updateTotal() {
            const total = quantity * pricePerPax;
            document.getElementById('quantity').textContent = quantity;
            document.getElementById('total').textContent = 'IDR ' + total.toLocaleString('id-ID');
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
                    btn.classList.remove('bg-[#3F51B5]', 'text-white', 'border-[#3F51B5]');
                    btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
                });
                this.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                this.classList.add('bg-[#3F51B5]', 'text-white', 'border-[#3F51B5]');
            });
        });
    </script>
@endsection
