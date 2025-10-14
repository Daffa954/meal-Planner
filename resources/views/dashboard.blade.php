<x-layout>
    <x-navbar-user></x-navbar-user>

    <div class="min-h-screen bg-gray-50">
        <!-- Header Section -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-900">
                        👋 Selamat Datang, {{ Auth::user()->name }}
                    </h1>
                    <p class="text-lg text-gray-600 mt-2">
                        {{ $userData['greeting'] }}
                    </p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-4 border">
                    <div class="text-2xl font-bold text-[#4BA095]">{{ $stats['total_children'] }}</div>
                    <div class="text-sm text-gray-600">Total Anak</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4 border">
                    <div class="text-2xl font-bold text-[#7B5E3C]">{{ $stats['active_plans'] }}</div>
                    <div class="text-sm text-gray-600">Plan Aktif</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4 border">
                    <div class="text-2xl font-bold text-[#F5B947]">{{ $stats['favorite_recipes'] }}</div>
                    <div class="text-sm text-gray-600">Resep Saya</div>
                </div>
                
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Left Column - Profil Anak -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Profil Anak Section -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Profil Anak</h2>
                            <a href="{{ route('children.create') }}"
                                class="bg-[#4BA095] text-white px-4 py-2 rounded-lg hover:bg-[#3a887d] transition flex items-center space-x-2">
                                <span>+</span>
                                <span>Tambah Anak</span>
                            </a>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach ($children as $child)
                                <div
                                    class="border-2 border-gray-200 rounded-xl p-4 hover:border-[#4BA095] transition group">
                                    <div class="flex items-center space-x-4">
                                        <!-- Foto Anak -->
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                                <span class="text-2xl">👶</span>
                                            </div>
                                        </div>

                                        <!-- Info Anak -->
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 text-lg">{{ $child['name'] }}</h3>
                                            <p class="text-gray-600">{{ $child['age'] }}</p>
                                            <p class="text-sm text-gray-500">Plan terakhir:
                                                {{ $child['last_meal_plan'] }}</p>
                                        </div>

                                        <!-- Action Button -->
                                        <div class="flex-shrink-0">
                                            <a href="{{ route('meal-plans.create', ['child_id' => $child['id']]) }}"
                                                class="bg-[#7B5E3C] text-white px-3 py-2 rounded-lg hover:bg-[#6a4f32] transition text-sm">
                                                Buat Plan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Empty State atau Card Tambah -->
                            @if (count($children) == 0)
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#4BA095] transition group">
                                    <div class="text-4xl mb-2">👶</div>
                                    <h3 class="font-semibold text-gray-900 mb-2">Belum ada profil anak</h3>
                                    <p class="text-gray-600 mb-4">Tambahkan profil anak untuk mulai membuat meal plan
                                    </p>
                                    <a href="{{ route('children.create') }}"
                                        class="bg-[#4BA095] text-white px-4 py-2 rounded-lg hover:bg-[#3a887d] transition inline-block">
                                        Tambah Anak Pertama
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Kalender Jadwal Meal Plan -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Kalender Meal Plan</h2>
                            <div class="flex space-x-2">
                                <button onclick="previousMonth()" class="bg-gray-100 p-2 rounded-lg hover:bg-gray-200 transition">
                                    ←
                                </button>
                                <button onclick="nextMonth()" class="bg-gray-100 p-2 rounded-lg hover:bg-gray-200 transition">
                                    →
                                </button>
                            </div>
                        </div>

                        <div id="calendar" class="mb-4">
                            <!-- Calendar akan diisi via JavaScript -->
                        </div>

                        <!-- Legend -->
                        <div class="flex flex-wrap gap-4 text-xs">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-[#4BA095] rounded-full"></div>
                                <span>Sarapan</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-[#7B5E3C] rounded-full"></div>
                                <span>Makan Siang</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-[#F5B947] rounded-full"></div>
                                <span>Makan Malam</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-[#E76F51] rounded-full"></div>
                                <span>Camilan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Quick Actions & Kalender -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    

                    <!-- Jadwal Hari Ini -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">📅 Jadwal Hari Ini</h2>
                        <div id="todaySchedule" class="space-y-3">
                            <!-- Jadwal akan diisi via JavaScript -->
                            <div class="text-center py-4 text-gray-500">
                                <p>Memuat jadwal...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tips & Saran Section -->
                    <div class="bg-gradient-to-br from-[#4BA095] to-[#7B5E3C] rounded-2xl shadow-sm p-6 text-white">
                        <h2 class="text-xl font-bold mb-4">💡 Tips Hari Ini</h2>
                        <div class="space-y-3">
                            <div class="bg-white/10 rounded-lg p-3">
                                <p class="font-medium">Variasi makanan penting untuk tumbuh kembang anak</p>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3">
                                <p class="font-medium">Pastikan cukup serat dari buah dan sayuran</p>
                            </div>
                            <div class="bg-white/10 rounded-lg p-3">
                                <p class="font-medium">Minum air putih yang cukup di antara waktu makan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data meal plans (contoh - nanti diganti dengan data dari controller)
        const mealPlansData = {
            @foreach($mealPlans ?? [] as $plan)
                "{{ $plan->date }}": [
                    @foreach($plan->recipes as $recipe)
                    {
                        type: "{{ $recipe->pivot->type }}",
                        name: "{{ $recipe->name }}",
                        time: "{{ $recipe->pivot->time }}",
                        child: "{{ $plan->children->name }}"
                    },
                    @endforeach
                ],
            @endforeach
        };

        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        // Render calendar
        function renderCalendar() {
            const calendarEl = document.getElementById('calendar');
            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const startingDay = firstDay.getDay();
            const monthLength = lastDay.getDate();

            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            // Calendar header
            let calendarHTML = `
                <div class="text-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">${monthNames[currentMonth]} ${currentYear}</h3>
                </div>
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div class="text-center text-sm font-medium text-gray-500">Min</div>
                    <div class="text-center text-sm font-medium text-gray-500">Sen</div>
                    <div class="text-center text-sm font-medium text-gray-500">Sel</div>
                    <div class="text-center text-sm font-medium text-gray-500">Rab</div>
                    <div class="text-center text-sm font-medium text-gray-500">Kam</div>
                    <div class="text-center text-sm font-medium text-gray-500">Jum</div>
                    <div class="text-center text-sm font-medium text-gray-500">Sab</div>
                </div>
                <div class="grid grid-cols-7 gap-1">
            `;

            // Empty cells for days before the first day of the month
            for (let i = 0; i < startingDay; i++) {
                calendarHTML += `<div class="h-8"></div>`;
            }

            // Days of the month
            for (let day = 1; day <= monthLength; day++) {
                const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const hasMealPlan = mealPlansData[dateStr];
                const isToday = currentDate.toDateString() === new Date(currentYear, currentMonth, day).toDateString();
                
                let dayClasses = "h-8 flex items-center justify-center text-sm rounded relative cursor-pointer ";
                let dayContent = day;

                if (isToday) {
                    dayClasses += "bg-[#4BA095] text-white font-bold ";
                } else {
                    dayClasses += "hover:bg-gray-100 ";
                }

                if (hasMealPlan) {
                    // Add meal plan indicators
                    const mealTypes = [...new Set(hasMealPlan.map(meal => meal.type))];
                    let indicators = '';
                    
                    mealTypes.forEach(type => {
                        let color = '';
                        switch(type) {
                            case 'breakfast': color = '#4BA095'; break;
                            case 'lunch': color = '#7B5E3C'; break;
                            case 'dinner': color = '#F5B947'; break;
                            case 'snack': color = '#E76F51'; break;
                            default: color = '#9CA3AF';
                        }
                        indicators += `<div class="w-1 h-1 rounded-full" style="background-color: ${color}"></div>`;
                    });

                    dayContent = `
                        <div class="relative">
                            ${day}
                            <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 flex space-x-1">
                                ${indicators}
                            </div>
                        </div>
                    `;
                }

                calendarHTML += `
                    <div class="${dayClasses}" onclick="showDayDetails('${dateStr}')">
                        ${dayContent}
                    </div>
                `;
            }

            calendarHTML += `</div>`;
            calendarEl.innerHTML = calendarHTML;

            // Update today's schedule
            updateTodaySchedule();
        }

        // Update today's schedule
        function updateTodaySchedule() {
            const todayStr = currentDate.toISOString().split('T')[0];
            const todayScheduleEl = document.getElementById('todaySchedule');
            const todayMeals = mealPlansData[todayStr];

            if (todayMeals && todayMeals.length > 0) {
                let scheduleHTML = '';

                // Group meals by time and sort
                const groupedMeals = todayMeals.reduce((acc, meal) => {
                    if (!acc[meal.time]) acc[meal.time] = [];
                    acc[meal.time].push(meal);
                    return acc;
                }, {});

                // Sort by time
                const sortedTimes = Object.keys(groupedMeals).sort();

                sortedTimes.forEach(time => {
                    const meals = groupedMeals[time];
                    meals.forEach(meal => {
                        let typeIcon = '';
                        let typeColor = '';

                        switch(meal.type) {
                            case 'breakfast': 
                                typeIcon = '🍳'; 
                                typeColor = 'bg-[#4BA095]';
                                break;
                            case 'lunch': 
                                typeIcon = '🍲'; 
                                typeColor = 'bg-[#7B5E3C]';
                                break;
                            case 'dinner': 
                                typeIcon = '🍛'; 
                                typeColor = 'bg-[#F5B947]';
                                break;
                            case 'snack': 
                                typeIcon = '🍎'; 
                                typeColor = 'bg-[#E76F51]';
                                break;
                            default: 
                                typeIcon = '🍽️'; 
                                typeColor = 'bg-gray-500';
                        }

                        scheduleHTML += `
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 ${typeColor} rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    ${typeIcon}
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">${meal.name}</div>
                                    <div class="text-sm text-gray-600">${meal.child} • ${time}</div>
                                </div>
                            </div>
                        `;
                    });
                });

                todayScheduleEl.innerHTML = scheduleHTML;
            } else {
                todayScheduleEl.innerHTML = `
                    <div class="text-center py-4 text-gray-500">
                        <p>Tidak ada jadwal meal plan untuk hari ini</p>
                        <a href="{{ route('meal-plans.create') }}" class="text-[#4BA095] hover:underline mt-2 inline-block">
                            Buat meal plan sekarang
                        </a>
                    </div>
                `;
            }
        }

        // Navigation functions
        function previousMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        }

        // Show day details
        function showDayDetails(dateStr) {
            const meals = mealPlansData[dateStr];
            if (meals && meals.length > 0) {
                let mealList = '';
                meals.forEach(meal => {
                    mealList += `
                        <div class="flex justify-between items-center p-2 border-b">
                            <div>
                                <div class="font-medium">${meal.name}</div>
                                <div class="text-sm text-gray-600">${meal.type} • ${meal.time}</div>
                            </div>
                            <div class="text-sm text-gray-500">${meal.child}</div>
                        </div>
                    `;
                });

                Swal.fire({
                    title: `Jadwal Meal Plan - ${new Date(dateStr).toLocaleDateString('id-ID')}`,
                    html: `<div class="text-left">${mealList}</div>`,
                    confirmButtonColor: '#4BA095',
                    confirmButtonText: 'Tutup'
                });
            } else {
                Swal.fire({
                    title: `Tidak Ada Jadwal - ${new Date(dateStr).toLocaleDateString('id-ID')}`,
                    text: 'Tidak ada meal plan untuk tanggal ini',
                    icon: 'info',
                    confirmButtonColor: '#4BA095',
                    confirmButtonText: 'Tutup'
                });
            }
        }

        // Initialize calendar when page loads
        document.addEventListener('DOMContentLoaded', function() {
            renderCalendar();
        });
    </script>
</x-layout>