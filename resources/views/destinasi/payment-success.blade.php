@extends('layouts.app')

@section('title', __('messages.payment_success'))

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Success Card -->
        <div class="bg-white rounded-3xl shadow-lg border border-gray-200 p-10 text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at top left, #3F51B5, transparent 55%), radial-gradient(circle at bottom right, #00BCD4, transparent 55%);"></div>
            <div class="relative">
                <!-- Title -->
                <h1 class="text-3xl font-bold text-[#1D2875] mb-4">{{ $destinasiName ?? __('messages.destinasi') }}</h1>
                
                <!-- Ticket Info -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-6 text-left shadow-inner border border-gray-100">
                    <p class="text-gray-700 mb-2 font-medium flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#3F51B5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 012 15.382V5.618a2 2 0 011.553-1.94L9 2l6 2 6-2 3 1v10l-3 1-6-2-6 2-6-2" />
                        </svg>
                        {{ $ticketName ?? __('messages.entrance_ticket') }}
                    </p>
                    <p class="text-gray-700 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#3F51B5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m3-10h2a2 2 0 012 2v9a2 2 0 01-2 2H6a2 2 0 01-2-2v-9a2 2 0 012-2h2" />
                        </svg>
                        {{ $quantity ?? 1 }} {{ __('messages.tiket') }}
                    </p>
                    <p class="text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#3F51B5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($date ?? now())->locale(app()->getLocale())->isoFormat('D MMMM YYYY') }}
                    </p>
                </div>

                <!-- Success Message -->
                <div class="mb-8">
                    <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center bg-gradient-to-br from-[#00BCD4] to-[#1DE9B6] text-4xl mb-4 shadow-lg">
                        🎉
                    </div>
                    <h2 class="text-2xl font-bold text-[#00BCD4]">{{ __('messages.payment_success') }}</h2>
                    <p class="text-gray-600 mt-2">{{ __('messages.payment_success_subtitle') }}</p>
                </div>

                <!-- Action Buttons -->
                <div class="grid gap-3">
                    <a href="{{ route('akun.tiket') }}" class="block w-full bg-[#1D2875] hover:bg-[#152052] text-white font-semibold py-3 rounded-xl transition duration-200">
                        {{ __('messages.view_my_tickets') }}
                    </a>
                    <a href="{{ route('beranda') }}" class="block w-full bg-white border-2 border-[#1D2875] text-[#1D2875] hover:bg-gray-50 font-semibold py-3 rounded-xl transition duration-200">
                        {{ __('messages.back_to_home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
