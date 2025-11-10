@extends('layouts.app')

@section('title', 'Akun - Mbolang')

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Greeting -->
        <h1 class="text-2xl font-bold text-[#3F51B5] mb-2">{{ __('messages.hi_name', ['name' => $user->nama]) }}</h1>

        <!-- Pengaturan Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-[#3F51B5] mb-6">{{ __('messages.settings') }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- List Favorit Kamu -->
                <a href="{{ route('akun.favorit') }}" class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-8 border border-gray-200 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 bg-[#3F51B5] rounded-full flex items-center justify-center mb-4 group-hover:bg-[#2c3a7f] transition">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ __('messages.my_favorites') }}</h3>
                </a>

                <!-- Ulasan Tempat -->
                <a href="{{ route('akun.ulasan') }}" class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-8 border border-gray-200 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 bg-[#3F51B5] rounded-full flex items-center justify-center mb-4 group-hover:bg-[#2c3a7f] transition">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ __('messages.my_reviews') }}</h3>
                </a>

                <!-- Tiket yang Terpesan -->
                <!-- <a href="{{ route('akun.tiket') }}" class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-8 border border-gray-200 flex flex-col items-center text-center group">
                    <div class="w-16 h-16 bg-[#3F51B5] rounded-full flex items-center justify-center mb-4 group-hover:bg-[#2c3a7f] transition">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ __('messages.my_tickets') }}</h3>
                </a> -->
            </div>
        </div>
    </main>
@endsection
