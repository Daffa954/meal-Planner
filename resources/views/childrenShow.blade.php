<x-layout>
    @section('title', $child->name . ' - Detail Profil - Meal Planner')
    <x-navbar-user></x-navbar-user>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-[#4BA095] to-[#7B5E3C] rounded-full flex items-center justify-center text-white text-2xl">
                            {{ $child->gender == 'male' ? '👦' : '👧' }}
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $child->name }}</h1>
                            <p class="text-gray-600 mt-1">
                                {{ $child->age_years }} tahun {{ $child->age_months }} bulan • 
                                {{ $child->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('meal-plans.create', ['child_id' => $child->id]) }}"
                            class="bg-[#7B5E3C] text-white px-6 py-3 rounded-lg hover:bg-[#6a4f32] transition font-semibold flex items-center">
                            📅 Buat Meal Plan
                        </a>
                        <a href="{{ route('children.edit', $child->id) }}"
                            class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition font-semibold flex items-center">
                            ✏️ Edit Profil
                        </a>
                        <a href="{{ route('children.index') }}"
                            class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition font-semibold flex items-center">
                            ← Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information Card -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900">📝 Informasi Dasar</h2>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                Profil Aktif
                            </span>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $child->name }}</p>
                                    </div>
                                    <div class="text-2xl">
                                        {{ $child->gender == 'male' ? '👦' : '👧' }}
                                    </div>
                                </div>

                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Jenis Kelamin</label>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">
                                        {{ $child->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                                    </p>
                                </div>

                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Usia</label>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">
                                        {{ $child->age_years }} tahun {{ $child->age_months }} bulan
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-3 bg-blue-50 rounded-lg text-center">
                                        <label class="block text-sm font-medium text-blue-600">Berat Badan</label>
                                        <p class="mt-1 text-2xl font-bold text-blue-700">{{ $child->weight }} kg</p>
                                    </div>
                                    <div class="p-3 bg-green-50 rounded-lg text-center">
                                        <label class="block text-sm font-medium text-green-600">Tinggi Badan</label>
                                        <p class="mt-1 text-2xl font-bold text-green-700">{{ $child->height }} cm</p>
                                    </div>
                                </div>

                                <div class="p-3 bg-purple-50 rounded-lg">
                                    <label class="block text-sm font-medium text-purple-600">BMI (Perkiraan)</label>
                                    @php
                                        $heightInMeter = $child->height / 100;
                                        $bmi = $child->weight / ($heightInMeter * $heightInMeter);
                                        $bmiCategory = '';
                                        if ($bmi < 18.5) $bmiCategory = 'Underweight';
                                        elseif ($bmi >= 18.5 && $bmi < 25) $bmiCategory = 'Normal';
                                        elseif ($bmi >= 25 && $bmi < 30) $bmiCategory = 'Overweight';
                                        else $bmiCategory = 'Obese';
                                    @endphp
                                    <p class="mt-1 text-lg font-semibold text-purple-700">
                                        {{ number_format($bmi, 1) }} ({{ $bmiCategory }})
                                    </p>
                                </div>

                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Ditambahkan</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $child->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Food Preferences Card -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900">🍽️ Preferensi Makanan</h2>
                            @if($child->preference)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    ✅ Terkonfigurasi
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    ⚠️ Belum Dikonfigurasi
                                </span>
                            @endif
                        </div>
                        
                        @if($child->preference)
                            <div class="space-y-6">
                                <!-- Allergens -->
                                @if($child->preference->allergens && count($child->preference->allergens) > 0)
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <span class="text-red-500 text-xl mr-2">⚠️</span>
                                            <h3 class="font-semibold text-red-800">Alergi Makanan</h3>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($child->preference->allergens as $allergen)
                                                <span class="bg-red-100 text-red-800 px-3 py-2 rounded-full text-sm font-medium flex items-center">
                                                    🚫 {{ $allergen }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Favorite Foods -->
                                @if($child->preference->favorite_foods && count($child->preference->favorite_foods) > 0)
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <span class="text-green-500 text-xl mr-2">❤️</span>
                                            <h3 class="font-semibold text-green-800">Makanan Favorit</h3>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($child->preference->favorite_foods as $food)
                                                <span class="bg-green-100 text-green-800 px-3 py-2 rounded-full text-sm font-medium flex items-center">
                                                    👍 {{ $food }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Disliked Foods -->
                                @if($child->preference->disliked_foods && count($child->preference->disliked_foods) > 0)
                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <span class="text-orange-500 text-xl mr-2">👎</span>
                                            <h3 class="font-semibold text-orange-800">Makanan Tidak Disukai</h3>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($child->preference->disliked_foods as $food)
                                                <span class="bg-orange-100 text-orange-800 px-3 py-2 rounded-full text-sm font-medium flex items-center">
                                                    👎 {{ $food }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Location -->
                                @if($child->preference->lokasi)
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <span class="text-blue-500 text-xl mr-2">📍</span>
                                            <h3 class="font-semibold text-blue-800">Lokasi</h3>
                                        </div>
                                        <p class="text-blue-700 font-medium">{{ $child->preference->lokasi }}</p>
                                        <p class="text-blue-600 text-sm mt-1">Untuk rekomendasi bahan lokal yang tersedia</p>
                                    </div>
                                @endif

                                <!-- Additional Notes -->
                                @if($child->preference->additional_notes)
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <span class="text-gray-500 text-xl mr-2">📝</span>
                                            <h3 class="font-semibold text-gray-800">Catatan Tambahan</h3>
                                        </div>
                                        <p class="text-gray-700">{{ $child->preference->additional_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 text-6xl mb-4">🍽️</div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada preferensi makanan</h3>
                                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                                    Tambahkan preferensi makanan untuk membantu AI menghasilkan resep yang lebih personalized dan sesuai dengan kebutuhan {{ $child->name }}.
                                </p>
                                <a href="{{ route('children.edit', $child->id) }}"
                                    class="bg-[#4BA095] text-white px-6 py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold inline-flex items-center">
                                    ✏️ Tambah Preferensi
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Recent Meal Plans -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900">📅 Riwayat Meal Plan</h2>
                            <a href="{{ route('meal-plans.create', ['child_id' => $child->id]) }}"
                                class="bg-[#4BA095] text-white px-4 py-2 rounded-lg hover:bg-[#3a887d] transition font-semibold text-sm">
                                ➕ Buat Baru
                            </a>
                        </div>

                        @if($child->mealPlans->count() > 0)
                            <div class="space-y-4">
                                @foreach($child->mealPlans->sortByDesc('date')->take(5) as $plan)
                                    <div class="border border-gray-200 rounded-lg hover:shadow-md transition">
                                        <div class="p-4">
                                            <div class="flex justify-between items-start mb-3">
                                                <div>
                                                    <h4 class="font-bold text-gray-900 text-lg">{{ $plan->date->format('d F Y') }}</h4>
                                                    <p class="text-gray-600 text-sm">
                                                        {{ $plan->date->translatedFormat('l') }} • 
                                                        {{ $plan->recipes->count() }} resep
                                                    </p>
                                                </div>
                                                <div class="flex space-x-2">
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">
                                                        {{ $plan->date->isToday() ? 'Hari Ini' : ($plan->date->isFuture() ? 'Akan Datang' : 'Selesai') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Recipes Preview -->
                                            @if($plan->recipes->count() > 0)
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-3">
                                                    @foreach($plan->recipes->take(2) as $recipe)
                                                        <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded">
                                                            <div class="w-8 h-8 bg-[#4BA095] rounded-full flex items-center justify-center text-white text-xs">
                                                                @if($recipe->pivot->type == 'breakfast') 🍳
                                                                @elseif($recipe->pivot->type == 'lunch') 🍲
                                                                @elseif($recipe->pivot->type == 'dinner') 🍛
                                                                @elseif($recipe->pivot->type == 'snack') 🍎
                                                                @else 👨‍🍳
                                                                @endif
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $recipe->name }}</p>
                                                                <p class="text-xs text-gray-600">{{ $recipe->pivot->time }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                @if($plan->recipes->count() > 2)
                                                    <p class="text-sm text-gray-600 text-center">
                                                        +{{ $plan->recipes->count() - 2 }} resep lainnya
                                                    </p>
                                                @endif

                                                <!-- Nutrition Summary -->
                                                @php
                                                    $totalCalories = $plan->recipes->sum(function($recipe) {
                                                        return $recipe->nutrition->calories ?? 0;
                                                    });
                                                @endphp
                                                <div class="mt-3 pt-3 border-t border-gray-200">
                                                    <div class="flex justify-between items-center text-sm">
                                                        <span class="text-gray-600">Total Kalori:</span>
                                                        <span class="font-semibold text-gray-900">{{ $totalCalories }} kkal</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-center py-4 text-gray-500">
                                                    <p>Belum ada resep dalam meal plan ini</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 rounded-b-lg border-t border-gray-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600">
                                                    Dibuat {{ $plan->created_at->diffForHumans() }}
                                                </span>
                                                <a href="{{ route('meal-plans.index') }}?date={{ $plan->date->format('Y-m-d') }}"
                                                    class="text-[#4BA095] hover:text-[#3a887d] text-sm font-semibold">
                                                    Lihat Detail →
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($child->mealPlans->count() > 5)
                                <div class="mt-6 text-center">
                                    <a href="{{ route('meal-plans.index') }}?child_id={{ $child->id }}"
                                        class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition font-semibold inline-flex items-center">
                                        📋 Lihat Semua Meal Plan
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 text-6xl mb-4">📅</div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada meal plan</h3>
                                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                                    Mulai buat meal plan pertama untuk {{ $child->name }} dengan resep yang sesuai dengan preferensi dan kebutuhan nutrisinya.
                                </p>
                                <div class="flex justify-center space-x-4">
                                    <a href="{{ route('meal-plans.create', ['child_id' => $child->id]) }}"
                                        class="bg-[#4BA095] text-white px-6 py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold inline-flex items-center">
                                        📅 Buat Meal Plan Manual
                                    </a>
                                    <a href="{{ route('recipes.generate', ['child_id' => $child->id]) }}"
                                        class="bg-[#7B5E3C] text-white px-6 py-3 rounded-lg hover:bg-[#6a4f32] transition font-semibold inline-flex items-center">
                                        🎯 Generate dengan AI
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">🚀 Aksi Cepat</h2>
                        <div class="space-y-3">
                            <a href="{{ route('meal-plans.create', ['child_id' => $child->id]) }}"
                                class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition group">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition">
                                    <span class="text-blue-600 text-lg">📅</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-900">Buat Meal Plan</span>
                                    <p class="text-sm text-gray-600">Rencanakan makanan harian</p>
                                </div>
                            </a>

                            <a href="{{ route('recipes.generate', ['child_id' => $child->id]) }}"
                                class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition group">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition">
                                    <span class="text-green-600 text-lg">🎯</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-900">Generate Resep AI</span>
                                    <p class="text-sm text-gray-600">Resep personalized</p>
                                </div>
                            </a>

                            <a href="{{ route('children.edit', $child->id) }}"
                                class="flex items-center space-x-3 p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition group">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center group-hover:bg-yellow-200 transition">
                                    <span class="text-yellow-600 text-lg">✏️</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-900">Edit Profil</span>
                                    <p class="text-sm text-gray-600">Update informasi anak</p>
                                </div>
                            </a>

                            <a href="{{ route('children.index') }}"
                                class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition group">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-gray-200 transition">
                                    <span class="text-gray-600 text-lg">👥</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-900">Semua Anak</span>
                                    <p class="text-sm text-gray-600">Lihat semua profil</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-gradient-to-br from-[#4BA095] to-[#7B5E3C] rounded-2xl shadow-sm p-6 text-white">
                        <h2 class="text-xl font-bold mb-6">📊 Statistik</h2>
                        <div class="space-y-4">
                            <div class="text-center p-4 bg-white/10 rounded-lg">
                                <div class="text-3xl font-bold">{{ $child->mealPlans->count() }}</div>
                                <div class="text-sm opacity-90">Total Meal Plan</div>
                            </div>
                            <div class="text-center p-4 bg-white/10 rounded-lg">
                                <div class="text-3xl font-bold">
                                    {{ $child->mealPlans->sum(fn($plan) => $plan->recipes->count()) }}
                                </div>
                                <div class="text-sm opacity-90">Total Resep</div>
                            </div>
                            <div class="text-center p-4 bg-white/10 rounded-lg">
                                <div class="text-3xl font-bold">
                                    {{ $child->mealPlans->where('date', '>=', now()->format('Y-m-d'))->count() }}
                                </div>
                                <div class="text-sm opacity-90">Plan Aktif</div>
                            </div>
                            <div class="text-center p-4 bg-white/10 rounded-lg">
                                <div class="text-3xl font-bold">
                                    {{ $child->mealPlans->where('date', '<', now()->format('Y-m-d'))->count() }}
                                </div>
                                <div class="text-sm opacity-90">Plan Selesai</div>
                            </div>
                        </div>
                    </div>

                    <!-- Health Information -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">❤️ Informasi Kesehatan</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Usia</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $child->age_years }}th {{ $child->age_months }}bln
                                </span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Berat Badan</span>
                                <span class="font-semibold text-gray-900">{{ $child->weight }} kg</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Tinggi Badan</span>
                                <span class="font-semibold text-gray-900">{{ $child->height }} cm</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">BMI</span>
                                <span class="font-semibold text-gray-900">{{ number_format($bmi, 1) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="bg-blue-50 rounded-2xl shadow-sm border border-blue-200 p-6">
                        <h2 class="text-xl font-bold text-blue-900 mb-4">💡 Tips untuk {{ $child->name }}</h2>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-500 mt-1">•</span>
                                <p class="text-blue-800 text-sm">Pastikan variasi makanan untuk nutrisi yang seimbang</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-500 mt-1">•</span>
                                <p class="text-blue-800 text-sm">Sesuaikan porsi dengan usia dan aktivitas</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-500 mt-1">•</span>
                                <p class="text-blue-800 text-sm">Perhatikan alergi dan preferensi makanan</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-500 mt-1">•</span>
                                <p class="text-blue-800 text-sm">Minum air yang cukup di antara waktu makan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function untuk menghitung dan menampilkan usia dalam bulan
        function calculateAgeInMonths() {
            const years = {{ $child->age_years }};
            const months = {{ $child->age_months }};
            const totalMonths = (years * 12) + months;
            
            document.getElementById('ageInMonths').textContent = totalMonths + ' bulan';
        }

        // Initialize saat page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateAgeInMonths();
        });
    </script>
</x-layout>