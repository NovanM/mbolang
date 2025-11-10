@extends('layouts.app')

@section('title', __('messages.add_review') . ' - ' . $destinasi->nama_destinasi)

@section('body-class', 'bg-white')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <form action="{{ route('destinasi.store-ulasan', $destinasi->id_destinasi) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                <!-- Left Side - Image -->
                <div>
                    <div class="relative w-full rounded-[30px] overflow-hidden ">
                        @if($destinasi->foto)
                            <img src="{{ asset($destinasi->foto) }}" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-[520px] object-cover">
                        @else
                            <div class="w-full h-[520px] bg-gradient-to-br from-[#1F3C88] to-[#0D1F4F] flex items-center justify-center text-white text-6xl font-extrabold">
                                {{ strtoupper(substr($destinasi->nama_destinasi, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Side - Form -->
                <div class="bg-white  rounded-[26px]  px-8 py-10">
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-extrabold text-[#1F3C88] mb-2">{{ __('messages.add_review') }}</h1>
                        <p class="text-[#4F5E95]">{{ __('messages.review_prompt') }}</p>
                    </div>

                    <!-- Destinasi Info -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-[#1F3C88] mb-1">{{ $destinasi->nama_destinasi }}</h2>
                        <p class="text-[#7A87A6] text-sm">{{ $destinasi->lokasi }}</p>
                    </div>

                    <!-- Rating Section -->
                    <div class="mb-8">
                        <h3 class="text-base font-semibold text-[#1F3C88] mb-4 uppercase tracking-wide">{{ __('messages.rating') }}</h3>
                        <div class="flex gap-4" id="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})" class="rating-star transition-transform hover:scale-110 focus:outline-none">
                                <svg class="w-12 h-12 text-[#E5E7F9] fill-current drop-shadow-[0_6px_12px_rgba(250,191,36,0.3)]" viewBox="0 0 20 20" data-rating="{{ $i }}">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            </button>
                            @endfor
                        </div>
                        <input type="hidden" id="rating-input" name="rating" value="{{ old('rating', 0) }}" required>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ulasan Section -->
                    <div class="mb-8">
                        <h3 class="text-base font-semibold text-[#1F3C88] mb-4 uppercase tracking-wide">{{ __('messages.your_review') }}</h3>
                        <textarea 
                            id="ulasan-textarea" 
                            name="komentar" 
                            rows="6" 
                            class="w-full px-5 py-4 border border-[#E0E6FF] rounded-[18px] focus:outline-none focus:ring-4 focus:ring-[#E1E8FF] focus:border-[#304DFF] resize-none  text-sm text-[#1D2756] placeholder:text-[#9AA6C5]"
                            placeholder="{{ __('messages.write_here') }}"
                            required>{{ old('komentar') }}</textarea>
                        @error('komentar')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-[#122A6A] text-white py-4 rounded-full font-semibold text-lg hover:bg-[#0D1F4F] transition shadow-[0_16px_30px_rgba(15,32,84,0.28)]">
                        {{ __('messages.submit_review') }}
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script>
        let selectedRating = Number(document.getElementById('rating-input').value || 0);
        const activeStarClass = ['text-[#FBBF24]'];
        const inactiveStarClass = ['text-[#E5E7F9]'];

        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('rating-input').value = rating;
            
            // Update star colors
            const stars = document.querySelectorAll('.rating-star svg');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove(...inactiveStarClass);
                    star.classList.add(...activeStarClass);
                } else {
                    star.classList.remove(...activeStarClass);
                    star.classList.add(...inactiveStarClass);
                }
            });
        }

        // Hover effect for stars
        document.querySelectorAll('.rating-star').forEach((button, index) => {
            button.addEventListener('mouseenter', () => {
                const stars = document.querySelectorAll('.rating-star svg');
                stars.forEach((star, i) => {
                    if (i <= index) {
                        star.classList.remove(...inactiveStarClass);
                        star.classList.add(...activeStarClass);
                    } else {
                        star.classList.remove(...activeStarClass);
                        star.classList.add(...inactiveStarClass);
                    }
                });
            });
        });

        // Reset to selected rating on mouse leave
        document.getElementById('rating-stars').addEventListener('mouseleave', () => {
            if (selectedRating > 0) {
                setRating(selectedRating);
            } else {
                const stars = document.querySelectorAll('.rating-star svg');
                stars.forEach(star => {
                    star.classList.remove(...activeStarClass);
                    star.classList.add(...inactiveStarClass);
                });
            }
        });

        if (selectedRating > 0) {
            setRating(selectedRating);
        }
    </script>
@endsection
