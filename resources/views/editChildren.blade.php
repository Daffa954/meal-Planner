<x-layout>
    @section('title', 'Tambah Anak - Meal Planner')
    <x-navbar-user></x-navbar-user>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            {{ isset($child) ? 'Edit Profil Anak' : 'Tambah Profil Anak' }}
                        </h1>
                        <p class="text-gray-600 mt-2">
                            {{ isset($child) ? 'Perbarui informasi profil anak' : 'Tambahkan profil anak baru untuk personalisasi meal plan' }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('children.index') }}"
                            class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition font-semibold flex items-center">
                            ← Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-sm border p-6">
                <form action="{{ isset($child) ? route('children.update', $child) : route('children.store') }}" method="POST">
                    @csrf
                    @if(isset($child))
                        @method('PUT')
                    @endif

                    <div class="space-y-6">
                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">📝 Informasi Dasar</h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Anak *
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $child->name ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="Masukkan nama anak" required>
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Jenis Kelamin *
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label class="relative">
                                            <input type="radio" name="gender" value="male" 
                                                {{ old('gender', $child->gender ?? '') == 'male' ? 'checked' : '' }}
                                                class="sr-only peer" required>
                                            <div class="p-3 border-2 border-gray-200 rounded-lg text-center cursor-pointer peer-checked:border-[#4BA095] peer-checked:bg-[#4BA095]/5 transition">
                                                <div class="text-xl mb-1">👦</div>
                                                <span class="font-medium text-sm">Laki-laki</span>
                                            </div>
                                        </label>
                                        <label class="relative">
                                            <input type="radio" name="gender" value="female"
                                                {{ old('gender', $child->gender ?? '') == 'female' ? 'checked' : '' }}
                                                class="sr-only peer" required>
                                            <div class="p-3 border-2 border-gray-200 rounded-lg text-center cursor-pointer peer-checked:border-[#4BA095] peer-checked:bg-[#4BA095]/5 transition">
                                                <div class="text-xl mb-1">👧</div>
                                                <span class="font-medium text-sm">Perempuan</span>
                                            </div>
                                        </label>
                                    </div>
                                    @error('gender')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Age -->
                            <div class="grid md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <label for="age_years" class="block text-sm font-medium text-gray-700 mb-2">
                                        Usia (Tahun) *
                                    </label>
                                    <input type="number" id="age_years" name="age_years" 
                                        value="{{ old('age_years', $child->age_years ?? '') }}"
                                        min="0" max="18"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="0" required>
                                    @error('age_years')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="age_months" class="block text-sm font-medium text-gray-700 mb-2">
                                        Usia (Bulan) *
                                    </label>
                                    <input type="number" id="age_months" name="age_months"
                                        value="{{ old('age_months', $child->age_months ?? '') }}"
                                        min="0" max="11"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="0" required>
                                    @error('age_months')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Physical Measurements -->
                            <div class="grid md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                                        Berat Badan (kg) *
                                    </label>
                                    <input type="number" id="weight" name="weight" step="0.1"
                                        value="{{ old('weight', $child->weight ?? '') }}"
                                        min="1" max="100"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="Contoh: 15.5" required>
                                    @error('weight')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="height" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tinggi Badan (cm) *
                                    </label>
                                    <input type="number" id="height" name="height" step="0.1"
                                        value="{{ old('height', $child->height ?? '') }}"
                                        min="30" max="200"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="Contoh: 95.5" required>
                                    @error('height')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Food Preferences -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">🍽️ Preferensi Makanan</h3>
                            <p class="text-sm text-gray-600 mb-4">Informasi ini akan membantu AI menghasilkan resep yang sesuai</p>
                            
                            <div class="space-y-4">
                                <!-- Allergens -->
                                <div>
                                    <label for="allergens" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alergi Makanan (opsional)
                                    </label>
                                    <input type="text" id="allergens" name="allergens"
                                        value="{{ old('allergens', isset($child->preference->allergens) ? implode(', ', $child->preference->allergens) : '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="Contoh: kacang, seafood, susu, telur">
                                    <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma</p>
                                    @error('allergens')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Favorite Foods -->
                                <div>
                                    <label for="favorite_foods" class="block text-sm font-medium text-gray-700 mb-2">
                                        Makanan Favorit (opsional)
                                    </label>
                                    <input type="text" id="favorite_foods" name="favorite_foods"
                                        value="{{ old('favorite_foods', isset($child->preference->favorite_foods) ? implode(', ', $child->preference->favorite_foods) : '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="Contoh: ayam goreng, nasi, brokoli, pisang">
                                    <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma</p>
                                    @error('favorite_foods')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Disliked Foods -->
                                <div>
                                    <label for="disliked_foods" class="block text-sm font-medium text-gray-700 mb-2">
                                        Makanan Tidak Disukai (opsional)
                                    </label>
                                    <input type="text" id="disliked_foods" name="disliked_foods"
                                        value="{{ old('disliked_foods', isset($child->preference->disliked_foods) ? implode(', ', $child->preference->disliked_foods) : '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="Contoh: wortel, bayam, ikan">
                                    <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma</p>
                                    @error('disliked_foods')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Location -->
                                <div>
                                    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                                        Lokasi (opsional)
                                    </label>
                                    <input type="text" id="lokasi" name="lokasi"
                                        value="{{ old('lokasi', $child->preference->lokasi ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="Contoh: Jakarta, Bandung, Surabaya">
                                    <p class="text-xs text-gray-500 mt-1">Untuk rekomendasi bahan lokal</p>
                                    @error('lokasi')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Additional Notes -->
                                <div>
                                    <label for="additional_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Catatan Tambahan (opsional)
                                    </label>
                                    <textarea id="additional_notes" name="additional_notes" rows="3"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="Contoh: anak suka makanan berkuah, tidak suka pedas, dll...">{{ old('additional_notes', $child->preference->additional_notes ?? '') }}</textarea>
                                    @error('additional_notes')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('children.index') }}"
                                class="bg-gray-500 text-white px-8 py-3 rounded-lg hover:bg-gray-600 transition font-semibold">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-[#4BA095] text-white px-8 py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold flex items-center">
                                {{ isset($child) ? '💾 Update Profil' : '👶 Tambah Anak' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Real-time age display
        function updateAgeDisplay() {
            const years = document.getElementById('age_years').value || 0;
            const months = document.getElementById('age_months').value || 0;
            
            if (years > 0 || months > 0) {
                let display = '';
                if (years > 0) display += years + ' tahun ';
                if (months > 0) display += months + ' bulan';
                document.getElementById('age_display').textContent = display.trim();
            } else {
                document.getElementById('age_display').textContent = '0 tahun 0 bulan';
            }
        }

        document.getElementById('age_years').addEventListener('input', updateAgeDisplay);
        document.getElementById('age_months').addEventListener('input', updateAgeDisplay);

        // Initialize age display
        document.addEventListener('DOMContentLoaded', updateAgeDisplay);
    </script>
</x-layout>