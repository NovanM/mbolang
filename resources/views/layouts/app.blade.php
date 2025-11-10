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
                    <a href="{{ route('beranda') }}" class="@if(request()->routeIs('beranda')) text-[#3F51B5] font-semibold @else text-gray-600 hover:text-[#00BCD4] @endif transition">Beranda</a>
                    <a href="{{ route('itinerary.create') }}" class="@if(request()->routeIs('itinerary.*')) text-[#3F51B5] font-semibold @else text-gray-600 hover:text-[#00BCD4] @endif transition">Membuat Perjalanan</a>
                    <a href="{{ route('plan.list') }}" class="@if(request()->routeIs('plan.*')) text-[#3F51B5] font-semibold @else text-gray-600 hover:text-[#00BCD4] @endif transition">Plan</a>
                    
                    @auth
                    <a href="{{ route('akun.index') }}" class="@if(request()->routeIs('akun.*')) text-[#3F51B5] font-semibold @else text-gray-600 hover:text-[#00BCD4] @endif transition">Akun</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-[#00BCD4] transition">Logout</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-[#00BCD4] transition">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-[#00BCD4] text-white px-6 py-2 rounded-lg hover:bg-[#00ACC1] transition">Daftar</a>
                    @endauth
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
