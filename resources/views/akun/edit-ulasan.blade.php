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
                    <label for="rating" class="block text-sm font-semibold text-[#1F3C88] mb-2">{{ __('messages.rating') }}</label>
                    <select id="rating" name="rating" required class="w-full px-4 py-3 border border-[#6383FF] rounded-[14px] focus:outline-none focus:ring-4 focus:ring-[#E1E8FF] focus:border-[#304DFF]">
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected(old('rating', $ulasan->rating) == $i)>{{ $i }} / 5</option>
                        @endfor
                    </select>
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
