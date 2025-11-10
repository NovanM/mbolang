@extends('layouts.app')

@section('title', 'Membuat Perjalanan - Mbolang')

@section('body-class', 'bg-gray-50')

@push('styles')
<style>
    /* Custom date picker styling */
    .calendar-wrapper {
        max-width: 420px;
        margin: 0 auto;
    }
    
    .calendar-container {
        background: #2C3E65;
        border-radius: 1.5rem;
        padding: 1.25rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .calendar-header {
        color: white;
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 0.5rem;
    }
    
    .calendar-header button {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        transition: background 0.2s;
    }
    
    .calendar-header button:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    
    .calendar-inner {
        background: white;
        border-radius: 1.25rem;
        padding: 1.5rem 1rem;
    }
    
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.5rem;
    }
    
    .calendar-day-header {
        color: #9CA3AF;
        font-size: 0.875rem;
        text-align: center;
        padding: 0.5rem 0;
        font-weight: 500;
    }
    
    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s;
        color: #374151;
        font-size: 0.9375rem;
        font-weight: 500;
        background: #E5E7EB;
    }
    
    .calendar-day:hover:not(.other-month):not(.selected) {
        background: #D1D5DB;
        transform: scale(1.05);
    }
    
    .calendar-day.other-month {
        color: #9CA3AF;
        background: transparent;
        font-weight: 400;
    }
    
    .calendar-day.selected {
        background: #3B82F6;
        color: white;
        font-weight: 600;
        transform: scale(1.05);
    }
    
    .calendar-day.today {
        box-shadow: 0 0 0 2px #3B82F6;
    }
    
    .calendar-icon {
        width: 24px;
        height: 24px;
        color: white;
    }
</style>
@endpush

@section('content')
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <form action="{{ route('itinerary.store') }}" method="POST" id="itinerary-form">
            @csrf
            
            <!-- Nama Perjalanan Section -->
            <div class="mb-12">
                <label for="nama_perjalanan" class="block text-[#3F51B5] text-2xl font-bold mb-4">
                    Nama Perjalanan
                </label>
                <input 
                    type="text" 
                    id="nama_perjalanan" 
                    name="nama_perjalanan" 
                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#3F51B5] focus:border-transparent text-lg bg-white shadow-sm"
                    placeholder="Tambahkan Nama Perjalanan"
                    value="{{ old('nama_perjalanan') }}"
                    required>
                @error('nama_perjalanan')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jadwal Section -->
            <div class="mb-12">
                <label class="block text-[#3F51B5] text-2xl font-bold mb-6">
                    Jadwal
                </label>
                
                <!-- Calendar Wrapper for Centering -->
                <div class="calendar-wrapper">
                    <!-- Calendar Container -->
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <button type="button" onclick="previousMonth()">
                                <svg class="calendar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <span id="calendar-month-year">November, 2025</span>
                            <button type="button" onclick="nextMonth()">
                                <svg class="calendar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Calendar Inner (White Background) -->
                        <div class="calendar-inner">
                            <!-- Calendar Grid -->
                            <div class="calendar-grid" id="calendar-grid">
                                <!-- Day headers -->
                                <div class="calendar-day-header">M</div>
                                <div class="calendar-day-header">T</div>
                                <div class="calendar-day-header">W</div>
                                <div class="calendar-day-header">T</div>
                                <div class="calendar-day-header">F</div>
                                <div class="calendar-day-header">S</div>
                                <div class="calendar-day-header">S</div>
                                
                                <!-- Days will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" id="tanggal_perjalanan" name="tanggal_perjalanan" value="{{ old('tanggal_perjalanan') }}" required>
                @error('tanggal_perjalanan')
                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="max-w-4xl mx-auto px-4">
                <button 
                    type="submit" 
                    class="w-full bg-[#2C3E65] text-white py-4 rounded-2xl font-semibold text-lg hover:bg-[#3d5078] transition-all shadow-lg hover:shadow-xl">
                    Tambahkan Perjalanan
                </button>
            </div>
        </form>
    </main>

    <script>
        let currentDate = new Date();
        let selectedDate = null;

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // Update month-year display
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                              'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            document.getElementById('calendar-month-year').textContent = `${monthNames[month]}, ${year}`;
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrevMonth = new Date(year, month, 0).getDate();
            
            // Adjust for Monday start (0 = Monday, 6 = Sunday)
            const firstDayAdjusted = firstDay === 0 ? 6 : firstDay - 1;
            
            const calendarGrid = document.getElementById('calendar-grid');
            
            // Clear previous days (keep headers)
            while (calendarGrid.children.length > 7) {
                calendarGrid.removeChild(calendarGrid.lastChild);
            }
            
            // Add previous month days
            for (let i = firstDayAdjusted - 1; i >= 0; i--) {
                const day = daysInPrevMonth - i;
                const dayElement = createDayElement(day, true, year, month - 1);
                calendarGrid.appendChild(dayElement);
            }
            
            // Add current month days
            const today = new Date();
            for (let day = 1; day <= daysInMonth; day++) {
                const isToday = (day === today.getDate() && month === today.getMonth() && year === today.getFullYear());
                const dayElement = createDayElement(day, false, year, month, isToday);
                calendarGrid.appendChild(dayElement);
            }
            
            // Add next month days to fill the grid
            const totalCells = calendarGrid.children.length - 7; // Subtract headers
            const remainingCells = 35 - totalCells; // 5 weeks * 7 days - headers
            for (let day = 1; day <= remainingCells; day++) {
                const dayElement = createDayElement(day, true, year, month + 1);
                calendarGrid.appendChild(dayElement);
            }
        }
        
        function createDayElement(day, isOtherMonth, year, month, isToday = false) {
            const div = document.createElement('div');
            div.className = 'calendar-day';
            div.textContent = day;
            
            if (isOtherMonth) {
                div.classList.add('other-month');
            }
            
            if (isToday) {
                div.classList.add('today');
            }
            
            if (!isOtherMonth) {
                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                div.onclick = () => selectDate(dateStr, div);
                
                // Check if this date is already selected
                if (selectedDate === dateStr) {
                    div.classList.add('selected');
                }
            }
            
            return div;
        }
        
        function selectDate(dateStr, element) {
            // Remove previous selection
            document.querySelectorAll('.calendar-day.selected').forEach(el => {
                el.classList.remove('selected');
            });
            
            // Add selection to clicked day
            element.classList.add('selected');
            selectedDate = dateStr;
            
            // Update hidden input
            document.getElementById('tanggal_perjalanan').value = dateStr;
        }
        
        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }
        
        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }
        
        // Initialize calendar
        document.addEventListener('DOMContentLoaded', function() {
            // Set to current date
            const today = new Date();
            currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
            
            // Pre-select today's date
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const todayDate = `${year}-${month}-${day}`;
            
            selectedDate = todayDate;
            document.getElementById('tanggal_perjalanan').value = todayDate;
            
            renderCalendar();
        });
    </script>
@endsection
