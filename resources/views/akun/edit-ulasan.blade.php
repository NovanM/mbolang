@extends('layouts.app')

@section('title', __('messages.edit_review') . ' - Mbolang')

@section('body-class', 'bg-gray-50')

@section('content')
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ route('akun.ulasan') }}" class="inline-flex items-center gap-2 text-[#3F51B5] hover:text-[#2c3a7f] font-semibold mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('messages.back') }}
        </a>

        <div class="bg-white rounded-3xl shadow-md border border-gray-200 p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-[#3F51B5] mb-2">{{ __('messages.edit_review') }}</h1>
                <p class="text-gray-600">{{ $ulasan->destinasi->nama_destinasi ?? __('messages.destinasi') }}</p>
            </div>

            <form method="POST" action="{{ route('akun.ulasan.update', $ulasan->id_ulasan) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-[#1F3C88] mb-3">{{ __('messages.rating') }}</label>
                    <div class="flex gap-4" id="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})" class="rating-star transition-transform hover:scale-110 focus:outline-none" aria-label="{{ $i }} {{ __('messages.of_5_stars') }}">
                                <svg class="w-12 h-12 text-[#E5E7F9] fill-current drop-shadow-[0_6px_12px_rgba(250,191,36,0.3)]" viewBox="0 0 20 20" data-rating="{{ $i }}">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', $ulasan->rating) }}" required>
                    @error('rating')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="komentar" class="block text-sm font-semibold text-[#1F3C88] mb-2">{{ __('messages.comment') }}</label>
                    <textarea id="komentar" name="komentar" rows="5" required class="w-full px-4 py-3 border border-[#6383FF] rounded-[14px] focus:outline-none focus:ring-4 focus:ring-[#E1E8FF] focus:border-[#304DFF]">{{ old('komentar', $ulasan->komentar) }}</textarea>
                    @error('komentar')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <a href="{{ route('akun.ulasan') }}" class="px-6 py-3 border border-[#3F51B5] text-[#3F51B5] rounded-xl font-semibold text-center hover:bg-[#3F51B5] hover:text-white transition">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit" class="px-6 py-3 bg-[#1D2875] text-white rounded-xl font-semibold hover:bg-[#131a5a] transition">
                        {{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let selectedRating = Number(document.getElementById('rating-input').value || 0);
        const activeStarClass = ['text-[#FBBF24]'];
        const inactiveStarClass = ['text-[#E5E7F9]'];

        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('rating-input').value = rating;

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

        window.setRating = setRating;

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
    });
</script>
@endpush
