@extends('layouts.app')

@section('title', 'Tambah Ulasan - ' . $destinasi->nama_destinasi)

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form action="{{ route('destinasi.store-ulasan', $destinasi->id_destinasi) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Side - Image -->
                <div>
                    <img src="https://picsum.photos/seed/{{ $destinasi->id_destinasi }}/600/400" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-[600px] object-cover rounded-2xl shadow-lg">
                </div>

                <!-- Right Side - Form -->
                <div>
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-[#3F51B5] mb-2">Tambahkan Ulasan</h1>
                        <p class="text-gray-600">Beri tahu kami, bagaimana kunjungan Anda?</p>
                    </div>

                    <!-- Destinasi Info -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-[#3F51B5] mb-1">{{ $destinasi->nama_destinasi }}</h2>
                        <p class="text-gray-600">{{ $destinasi->lokasi }}</p>
                    </div>

                    <!-- Rating Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-[#3F51B5] mb-4">Rating</h3>
                        <div class="flex gap-3" id="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})" class="rating-star transition-transform hover:scale-110">
                                <svg class="w-12 h-12 text-gray-300 fill-current" viewBox="0 0 20 20" data-rating="{{ $i }}">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            </button>
                            @endfor
                        </div>
                        <input type="hidden" id="rating-input" name="rating" value="0" required>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ulasan Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-[#3F51B5] mb-4">Ulasan</h3>
                        <textarea 
                            id="ulasan-textarea" 
                            name="komentar" 
                            rows="6" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3F51B5] focus:border-transparent resize-none"
                            placeholder="Tuliskan di sini"
                            required>{{ old('komentar') }}</textarea>
                        @error('komentar')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-[#1E3A8A] text-white py-4 rounded-lg font-semibold text-lg hover:bg-[#2c5aa0] transition shadow-lg">
                        Tambahkan Ulasan
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script>
        let selectedRating = 0;

        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('rating-input').value = rating;
            
            // Update star colors
            const stars = document.querySelectorAll('.rating-star svg');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        // Hover effect for stars
        document.querySelectorAll('.rating-star').forEach((button, index) => {
            button.addEventListener('mouseenter', () => {
                const stars = document.querySelectorAll('.rating-star svg');
                stars.forEach((star, i) => {
                    if (i <= index) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
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
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                });
            }
        });
    </script>
@endsection
