@extends('layouts.app')

@section('title', __('messages.payment_success'))

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Success Card -->
        <div class="bg-white rounded-3xl shadow-lg border-4 border-[#3F51B5] p-8 text-center">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-[#3F51B5] mb-2">{{ $destinasiName ?? __('messages.destinasi') }}</h1>
            
            <!-- Ticket Info -->
            <div class="text-left mb-6">
                <p class="text-gray-700 mb-1">{{ __('messages.entrance_ticket') }} {{ $destinasiName ?? __('messages.destinasi') }} + Eco Green Park</p>
                <p class="text-gray-700 mb-1">{{ $quantity ?? 5 }} {{ __('messages.tiket') }}</p>
                <p class="text-gray-700">{{ \Carbon\Carbon::parse($date ?? now())->locale(app()->getLocale())->isoFormat('D MMMM YYYY') }}</p>
            </div>

            <!-- Success Message -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[#00BCD4] mb-4">{{ __('messages.payment_success_message') }}</h2>
                <!-- Party Emoji -->
                <div class="text-6xl mb-4">🎉</div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('akun.tiket') }}" class="block w-full bg-[#3F51B5] hover:bg-[#1E3A8A] text-white font-semibold py-3 rounded-lg transition duration-200">
                    {{ __('messages.view_my_tickets') }}
                </a>
                <a href="{{ route('beranda') }}" class="block w-full bg-white border-2 border-[#3F51B5] text-[#3F51B5] hover:bg-gray-50 font-semibold py-3 rounded-lg transition duration-200">
                    {{ __('messages.back_to_home') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
