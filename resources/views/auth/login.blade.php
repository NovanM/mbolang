<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login') }} - Mbolang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-50 font-[Poppins]">
    <!-- Background Pattern -->
    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 " style="background-image: url({{ asset('images/pattern-auth.png') }}); background-size: cover; background-position: center;"></div>
    </div>

    <!-- Main Container -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl flex items-center justify-between gap-8 lg:gap-16">
            
            <!-- Left Side - Logo & Branding -->
            <div class="hidden lg:block w-1/2">
                <div class="mx-auto text-center">
                    <div class="inline-block">
                        <img src="{{ asset('images/logo.png') }}" alt="Mbolang Logo" class=" mx-auto">
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full max-w-md">
                <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-12">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex justify-center mb-8">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-cyan-400 via-teal-500 to-cyan-600 flex items-center justify-center shadow-lg">
                            <img src="{{ asset('images/logo.png') }}" alt="Mbolang Logo" class="w-12 h-16">
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-1">{{ __('messages.login') }}</h2>
                        <p class="text-3xl font-bold text-blue-600">{{ __('messages.welcome') }}</p>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.email') }}</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required 
                                autofocus
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none @error('email') border-red-500 @enderror"
                                placeholder="{{ __('messages.enter_email') }}"
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.password') }}</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    required
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none @error('password') border-red-500 @enderror"
                                    placeholder="{{ __('messages.enter_password') }}"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword()"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition"
                                >
                                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">{{ __('messages.remember_me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline">
                                    {{ __('messages.forgot_password') }}
                                </a>
                            @endif
                        </div> -->

                        <!-- Login Button -->
                        <button 
                            type="submit"
                            class="w-full bg-[#1E3A5F] hover:bg-[#152D4A] text-white font-semibold py-3.5 rounded-lg transition duration-200 shadow-lg hover:shadow-xl"
                        >
                            {{ __('messages.login') }}
                        </button>

                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">{{ __('messages.or') }}</span>
                            </div>
                        </div>

                        <!-- Google Login Button -->
                        <button 
                            type="button"
                            onclick="loginWithGoogle()"
                            class="w-full bg-white border border-gray-300 hover:border-gray-400 text-gray-700 font-medium py-3.5 rounded-lg transition duration-200 flex items-center justify-center gap-3 shadow-sm hover:shadow-md"
                        >
                            <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            {{ __('messages.login_with_google') }}
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-600">
                            {{ __('messages.no_account') }} 
                            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700 hover:underline">
                                {{ __('messages.register') }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                `;
            }
        }

        function loginWithGoogle() {
            // Implement Google OAuth login
            window.location.href = "{{ route('auth.google') ?? '#' }}";
        }

        // Auto-hide flash messages
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);
    </script>
</body>
</html>
