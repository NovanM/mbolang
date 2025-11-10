@extends('layouts.app')

@section('title', 'Checkout - ' . $destinasi->nama_destinasi)

@section('body-class', 'bg-gray-50')

@push('styles')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

@section('content')
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Order Summary Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
            <h1 class="text-2xl font-bold text-[#3F51B5] mb-4">{{ $destinasi->nama_destinasi }}</h1>
            
            <div class="space-y-2 mb-4">
                <p class="text-gray-700">Tiket Masuk {{ $destinasi->nama_destinasi }} + Eco Green Park</p>
                <p class="font-semibold text-gray-900">{{ $quantity }} Tiket</p>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <p class="text-sm text-gray-500 mb-2">Tanggal dipilih</p>
                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('D MMMM YYYY') }}</p>
            </div>
        </div>

        <!-- Detail Pemesanan Section -->
        <div class="mb-6">
            <h2 class="text-xl font-bold text-[#3F51B5] mb-4">Detail Pemesanan</h2>
            
            <form id="checkout-form" class="space-y-4">
                @csrf
                
                <input type="hidden" name="quantity" value="{{ $quantity }}">
                <input type="hidden" name="date" value="{{ $date }}">
                
                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-sm font-bold text-[#3F51B5] mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        class="w-full px-4 py-3 border-2 border-[#3F51B5] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3F51B5] focus:border-transparent"
                        required
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-[#3F51B5] mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full px-4 py-3 border-2 border-[#3F51B5] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3F51B5] focus:border-transparent"
                        required
                    >
                </div>

                <!-- Negara -->
                <div>
                    <label for="negara" class="block text-sm font-bold text-[#3F51B5] mb-2">Negara</label>
                    <input 
                        type="text" 
                        id="negara" 
                        name="negara" 
                        class="w-full px-4 py-3 border-2 border-[#3F51B5] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3F51B5] focus:border-transparent"
                        required
                    >
                </div>

                <!-- Total Price -->
                <div class="bg-gray-50 rounded-lg p-4 mt-6">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 font-medium">Total:</span>
                        <span class="text-2xl font-bold text-gray-900">IDR {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    id="pay-button"
                    class="w-full bg-[#1E3A8A] text-white py-4 rounded-lg font-semibold text-lg hover:bg-[#2c5aa0] transition shadow-lg mt-4"
                >
                    Kirim
                </button>
            </form>
        </div>
    </main>

    <script>
        document.getElementById('checkout-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const payButton = document.getElementById('pay-button');
            payButton.disabled = true;
            payButton.textContent = 'Processing...';
            
            const formData = new FormData(this);
            
            // Get quantity and date from form
            const quantity = formData.get('quantity');
            const visitDate = formData.get('date');
            
            try {
                const response = await fetch('{{ route("destinasi.process-payment", $destinasi->id_destinasi) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.snap_token) {
                    // Open Midtrans Snap
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            // Redirect to payment success page with order details
                            const successUrl = '{{ route("payment.success") }}' + 
                                '?order_id=' + data.order_id +
                                '&destinasi_id={{ $destinasi->id_destinasi }}' +
                                '&destinasi_name={{ urlencode($destinasi->nama_destinasi) }}' +
                                '&quantity=' + quantity +
                                '&date=' + visitDate;
                            window.location.href = successUrl;
                        },
                        onPending: function(result) {
                            alert('Menunggu pembayaran! Silakan selesaikan pembayaran Anda.');
                            window.location.href = '{{ route("akun.tiket") }}';
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal! Silakan coba lagi.');
                            payButton.disabled = false;
                            payButton.textContent = 'Kirim';
                        },
                        onClose: function() {
                            payButton.disabled = false;
                            payButton.textContent = 'Kirim';
                        }
                    });
                } else {
                    alert('Error: ' + (data.error || 'Terjadi kesalahan'));
                    payButton.disabled = false;
                    payButton.textContent = 'Kirim';
                }
            } catch (error) {
                alert('Error: ' + error.message);
                payButton.disabled = false;
                payButton.textContent = 'Kirim';
            }
        });
    </script>
@endsection
