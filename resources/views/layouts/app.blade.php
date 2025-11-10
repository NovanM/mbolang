<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mbolang - Platform Wisata Malang')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="@yield('body-class', 'bg-white')" style="font-family: 'Poppins', sans-serif;">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 @yield('nav-class', 'sticky top-0 z-50')">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Mbolang" class="h-10">
                    <span class="text-xl font-bold text-[#00BCD4]">Mbolang</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('beranda') }}" class="@if(request()->routeIs('beranda')) text-[#3F51B5] font-semibold @else text-gray-600 hover:text-[#00BCD4] @endif transition">{{ __('messages.beranda') }}</a>
                    <a href="{{ route('itinerary.create') }}" class="@if(request()->routeIs('itinerary.*')) text-[#3F51B5] font-semibold @else text-gray-600 hover:text-[#00BCD4] @endif transition">{{ __('messages.membuat_perjalanan') }}</a>
                    <a href="{{ route('plan.list') }}" class="@if(request()->routeIs('plan.*')) text-[#3F51B5] font-semibold @else text-gray-600 hover:text-[#00BCD4] @endif transition">{{ __('messages.plan') }}</a>
                    
                    @auth
                    <a href="{{ route('akun.index') }}" class="@if(request()->routeIs('akun.*')) text-[#3F51B5] font-semibold @else text-gray-600 hover:text-[#00BCD4] @endif transition">{{ __('messages.akun') }}</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-[#00BCD4] transition">{{ __('messages.logout') }}</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-[#00BCD4] transition">{{ __('messages.login') }}</a>
                    <a href="{{ route('register') }}" class="bg-[#00BCD4] text-white px-6 py-2 rounded-lg hover:bg-[#00ACC1] transition">{{ __('messages.register') }}</a>
                    @endauth

                    <!-- Language Switcher -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-gray-600 hover:text-[#00BCD4] transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ strtoupper(app()->getLocale()) }}</span>
                        </button>
                        <div class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('language.switch', 'id') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-lg {{ app()->getLocale() == 'id' ? 'bg-blue-50 text-[#3F51B5] font-semibold' : '' }}">
                                🇮🇩 Indonesia
                            </a>
                            <a href="{{ route('language.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-b-lg {{ app()->getLocale() == 'en' ? 'bg-blue-50 text-[#3F51B5] font-semibold' : '' }}">
                                🇬🇧 English
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Extra Navbar Items (for filter button, etc) -->
                @yield('navbar-extra')
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    @stack('scripts')
</body>
</html>
