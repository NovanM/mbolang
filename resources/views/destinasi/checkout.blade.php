@extends('layouts.app')

@section('title', __('messages.checkout') . ' - ' . $destinasi->nama_destinasi)

@section('body-class', 'bg-gray-50')

@push('styles')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

@section('content')
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Order Summary Card -->
        <div class="bg-[#F8FAFF] rounded-[26px] shadow-[0_20px_40px_rgba(16,35,71,0.12)] border border-[#E4E9FF] p-8 mb-8">
            <h1 class="text-[28px] font-extrabold text-[#1F3C88] mb-3">{{ $destinasi->nama_destinasi }}</h1>
            
            <div class="space-y-1.5 mb-6 text-[#3C4A7A]">
                <p class="text-base font-medium">{{ __('messages.entrance_ticket') }} {{ $destinasi->nama_destinasi }} + Eco Green Park</p>
                <p class="text-sm font-semibold uppercase tracking-wide text-[#1F3C88]">{{ trans_choice('messages.ticket_count', $quantity, ['count' => $quantity]) }}</p>
            </div>

            <div class="pt-5 border-t border-[#E0E6FF]">
                <p class="text-sm font-semibold text-[#9AA6C5] mb-2">{{ __('messages.selected_date') }}</p>
                <p class="text-base font-semibold text-[#1D2756]">{{ \Carbon\Carbon::parse($date)->locale(app()->getLocale())->isoFormat('D MMMM YYYY') }}</p>
            </div>
        </div>

        <!-- Booking Details Section -->
        <div class="mb-10">
            <h2 class="text-lg font-bold text-[#1F3C88] mb-5 uppercase tracking-wide">{{ __('messages.booking_details') }}</h2>
            
            <form id="checkout-form" class="space-y-5 bg-white border border-[#E4E9FF] rounded-[22px] shadow-[0_16px_32px_rgba(16,35,71,0.1)] px-6 sm:px-8 py-8">
                @csrf
                
                <input type="hidden" name="quantity" value="{{ $quantity }}">
                <input type="hidden" name="date" value="{{ $date }}">
                
                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-sm font-semibold text-[#1F3C88] mb-2">{{ __('messages.full_name') }}</label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        class="w-full px-4 py-3 border border-[#6383FF] rounded-[14px] focus:outline-none focus:ring-4 focus:ring-[#E1E8FF] focus:border-[#304DFF] shadow-[0_10px_18px_rgba(33,56,117,0.08)]"
                        required
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-[#1F3C88] mb-2">{{ __('messages.email') }}</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full px-4 py-3 border border-[#6383FF] rounded-[14px] focus:outline-none focus:ring-4 focus:ring-[#E1E8FF] focus:border-[#304DFF] shadow-[0_10px_18px_rgba(33,56,117,0.08)]"
                        required
                    >
                </div>

                <!-- Negara -->
                <div>
                    <label for="negara" class="block text-sm font-semibold text-[#1F3C88] mb-2">{{ __('messages.country') }}</label>
                    <input 
                        type="text" 
                        id="negara" 
                        name="negara" 
                        class="w-full px-4 py-3 border border-[#6383FF] rounded-[14px] focus:outline-none focus:ring-4 focus:ring-[#E1E8FF] focus:border-[#304DFF] shadow-[0_10px_18px_rgba(33,56,117,0.08)]"
                        required
                    >
                </div>

                <!-- Total Price -->
                <div class="bg-[#F6F8FF] rounded-[18px] px-6 py-5 mt-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-[#7A87A6]">{{ __('messages.total') }}:</span>
                        <span class="text-2xl font-extrabold text-[#1F3C88]">IDR {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    id="pay-button"
                    class="w-full bg-[#122A6A] text-white py-4 rounded-full font-semibold text-lg hover:bg-[#0D1F4F] transition shadow-[0_14px_28px_rgba(15,32,84,0.28)] mt-6"
                >
                    {{ __('messages.submit') }}
                </button>
            </form>
        </div>
    </main>

    <script>
        const checkoutMessages = {
            processing: @json(__('messages.processing')),
            submit: @json(__('messages.submit')),
            pending: @json(__('messages.payment_pending')),
            failed: @json(__('messages.payment_failed')),
            error: @json(__('messages.payment_error')),
            unknown: @json(__('messages.unknown_error'))
        };

        document.getElementById('checkout-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const payButton = document.getElementById('pay-button');
            payButton.disabled = true;
            payButton.textContent = checkoutMessages.processing;
            
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
                            alert(checkoutMessages.pending);
                            window.location.href = '{{ route("akun.tiket") }}';
                        },
                        onError: function(result) {
                            alert(checkoutMessages.failed);
                            payButton.disabled = false;
                            payButton.textContent = checkoutMessages.submit;
                        },
                        onClose: function() {
                            payButton.disabled = false;
                            payButton.textContent = checkoutMessages.submit;
                        }
                    });
                } else {
                    alert(checkoutMessages.error + ': ' + (data.error || checkoutMessages.unknown));
                    payButton.disabled = false;
                    payButton.textContent = checkoutMessages.submit;
                }
            } catch (error) {
                alert(checkoutMessages.error + ': ' + error.message);
                payButton.disabled = false;
                payButton.textContent = checkoutMessages.submit;
            }
        });
    </script>
@endsection
