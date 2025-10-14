<x-layout>

    @section('title', 'Tambah Profil Anak - Meal Planner')

    @section('content')
        <div class="min-h-screen bg-gray-50 py-8">
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Tambah Profil Anak</h1>
                    <p class="text-gray-600 mt-2">Lengkapi informasi anak untuk personalisasi meal plan</p>
                </div>

                <!-- Progress Steps -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        @foreach ([1 => 'Data Dasar', 2 => 'Preferensi Makan'] as $step => $label)
                            <div class="flex items-center">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center 
                                    {{ $step == 1 ? 'bg-[#4BA095] text-white' : 'bg-gray-200 text-gray-500' }}
                                    border-2 {{ $step == 1 ? 'border-[#4BA095]' : 'border-gray-300' }}">
                                        {{ $step }}
                                    </div>
                                    <span
                                        class="text-xs mt-1 {{ $step == 1 ? 'text-[#4BA095] font-medium' : 'text-gray-500' }}">
                                        {{ $label }}
                                    </span>
                                </div>
                                @if ($step < 3)
                                    <div class="w-16 h-1 bg-gray-200 mx-2"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Form Container -->
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <form id="childForm" action="{{ route('children.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Data Dasar -->
                        <div id="step1" class="space-y-6">

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                    placeholder="Masukkan nama anak">
                            </div>

                            <!-- Age -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Usia</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="age_years" class="block text-xs text-gray-500 mb-1">Tahun</label>
                                        <select id="age_years" name="age_years" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition">
                                            <option value="">Pilih tahun</option>
                                            @for ($i = 0; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }} tahun</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <label for="age_months" class="block text-xs text-gray-500 mb-1">Bulan</label>
                                        <select id="age_months" name="age_months" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition">
                                            <option value="">Pilih bulan</option>
                                            @for ($i = 0; $i <= 11; $i++)
                                                <option value="{{ $i }}">{{ $i }} bulan</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="relative">
                                        <input type="radio" name="gender" value="male" required class="sr-only peer">
                                        <div
                                            class="p-4 border-2 border-gray-200 rounded-lg text-center cursor-pointer peer-checked:border-[#4BA095] peer-checked:bg-[#4BA095]/5 transition">
                                            <div class="text-2xl mb-1">👦</div>
                                            <span class="font-medium">Laki-laki</span>
                                        </div>
                                    </label>
                                    <label class="relative">
                                        <input type="radio" name="gender" value="female" required class="sr-only peer">
                                        <div
                                            class="p-4 border-2 border-gray-200 rounded-lg text-center cursor-pointer peer-checked:border-[#4BA095] peer-checked:bg-[#4BA095]/5 transition">
                                            <div class="text-2xl mb-1">👧</div>
                                            <span class="font-medium">Perempuan</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Weight & Height -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan
                                        (kg)</label>
                                    <input type="number" id="weight" name="weight" step="0.1" min="1"
                                        max="100" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="Contoh: 15.5">
                                </div>
                                <div>
                                    <label for="height" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan
                                        (cm)</label>
                                    <input type="number" id="height" name="height" step="0.1" min="30"
                                        max="200" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                                        placeholder="Contoh: 95.5">
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Preferensi Makan (akan ditampilkan via JS) -->
                        <div id="step2" class="space-y-6 hidden">
                            <!-- Allergens -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Alergi Makanan</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @php
                                        $commonAllergens = [
                                            'Susu Sapi',
                                            'Telur',
                                            'Kacang',
                                            'Ikan',
                                            'Kerang',
                                            'Gandum',
                                            'Kedelai',
                                            'Seafood',
                                            'Madu',
                                            'Stroberi',
                                        ];
                                    @endphp
                                    @foreach ($commonAllergens as $allergen)
                                        <label
                                            class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                            <input type="checkbox" name="allergens[]" value="{{ $allergen }}"
                                                class="rounded text-[#4BA095] focus:ring-[#4BA095]">
                                            <span class="text-sm">{{ $allergen }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <input type="text" name="other_allergens" placeholder="Alergi lainnya..."
                                    class="w-full mt-3 px-4 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>

                            <!-- Favorite Foods -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Makanan Favorit</label>
                                <div class="space-y-2">
                                    <input type="text" id="favoriteFoodInput" placeholder="Tambahkan makanan favorit..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm">
                                    <button type="button" onclick="addFavoriteFood()"
                                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                                        + Tambah
                                    </button>
                                    <div id="favoriteFoodsList" class="flex flex-wrap gap-2 mt-2"></div>
                                </div>
                            </div>



                            <!-- Location -->
                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                                <select id="lokasi" name="lokasi"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition">
                                    <option value="">Pilih lokasi</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Medan">Medan</option>
                                    <option value="Makassar">Makassar</option>
                                    <option value="Bali">Bali</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>



                        <!-- Navigation Buttons -->
                        <div class="flex justify-between pt-6 border-t mt-8">
                            <button type="button" id="prevBtn" onclick="prevStep()"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition hidden">
                                ◀ Kembali
                            </button>
                            <button type="button" id="nextBtn" onclick="nextStep()"
                                class="ml-auto px-6 py-3 bg-[#4BA095] text-white rounded-lg hover:bg-[#3a887d] transition">
                                Lanjut ▶
                            </button>
                            <button type="submit" id="submitBtn"
                                class="px-6 py-3 bg-[#7B5E3C] text-white rounded-lg hover:bg-[#6a4f32] transition hidden">
                                ✅ Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            let currentStep = 1;
            const totalSteps = 2;

            // Arrays untuk menyimpan makanan
            let favoriteFoods = [];
            let dislikedFoods = [];

            function showStep(step) {
                // Sembunyikan semua steps
                document.querySelectorAll('[id^="step"]').forEach(el => {
                    el.classList.add('hidden');
                });

                // Tampilkan step yang aktif
                document.getElementById(`step${step}`).classList.remove('hidden');

                // Update tombol navigasi
                document.getElementById('prevBtn').classList.toggle('hidden', step === 1);
                document.getElementById('nextBtn').classList.toggle('hidden', step === totalSteps);
                document.getElementById('submitBtn').classList.toggle('hidden', step !== totalSteps);

                // Update progress indicator (bisa ditambahkan styling lebih advance)
                currentStep = step;
            }

            function nextStep() {
                if (validateStep(currentStep)) {
                    showStep(currentStep + 1);
                }
            }

            function prevStep() {
                showStep(currentStep - 1);
            }

            function validateStep(step) {
                switch (step) {
                    case 1:
                        const name = document.getElementById('name').value;
                        const ageYears = document.getElementById('age_years').value;
                        const ageMonths = document.getElementById('age_months').value;
                        const gender = document.querySelector('input[name="gender"]:checked');
                        const weight = document.getElementById('weight').value;
                        const height = document.getElementById('height').value;

                        if (!name || !ageYears || !ageMonths || !gender || !weight || !height) {
                            alert('Harap lengkapi semua data dasar terlebih dahulu.');
                            return false;
                        }
                        return true;

                    case 2:
                        // Step 2 validation bisa ditambahkan jika diperlukan
                        return true;

                    case 3:
                        // Step 3 validation
                        return true;
                }
                return true;
            }

            // Photo Preview
            function previewPhoto(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('photoPreview');
                        preview.innerHTML = `<img src="${e.target.result}" class="w-32 h-32 rounded-full object-cover">`;
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Favorite Foods Management
            function addFavoriteFood() {
                const input = document.getElementById('favoriteFoodInput');
                const food = input.value.trim();

                if (food && !favoriteFoods.includes(food)) {
                    favoriteFoods.push(food);
                    updateFoodList('favoriteFoodsList', favoriteFoods, 'favorite_foods');
                    input.value = '';
                }
            }

            function removeFavoriteFood(index) {
                favoriteFoods.splice(index, 1);
                updateFoodList('favoriteFoodsList', favoriteFoods, 'favorite_foods');
            }

            // Disliked Foods Management
            function addDislikedFood() {
                const input = document.getElementById('dislikedFoodInput');
                const food = input.value.trim();

                if (food && !dislikedFoods.includes(food)) {
                    dislikedFoods.push(food);
                    updateFoodList('dislikedFoodsList', dislikedFoods, 'disliked_foods');
                    input.value = '';
                }
            }

            function removeDislikedFood(index) {
                dislikedFoods.splice(index, 1);
                updateFoodList('dislikedFoodsList', dislikedFoods, 'disliked_foods');
            }

            function updateFoodList(containerId, foods, inputName) {
                const container = document.getElementById(containerId);
                container.innerHTML = '';

                // Update hidden inputs
                const existingInputs = document.querySelectorAll(`input[name="${inputName}[]"]`);
                existingInputs.forEach(input => input.remove());

                foods.forEach((food, index) => {
                    // Add to visual list
                    const tag = document.createElement('div');
                    tag.className =
                        'flex items-center space-x-1 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm';
                    tag.innerHTML = `
            <span>${food}</span>
            <button type="button" onclick="remove${inputName.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('')}(${index})" 
                    class="text-blue-600 hover:text-blue-800">×</button>
        `;
                    container.appendChild(tag);

                    // Add hidden input
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `${inputName}[]`;
                    hiddenInput.value = food;
                    document.getElementById('childForm').appendChild(hiddenInput);
                });
            }

            // Enter key untuk tambah makanan
            document.getElementById('favoriteFoodInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addFavoriteFood();
                }
            });

            document.getElementById('dislikedFoodInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addDislikedFood();
                }
            });

            // Initialize first step
            showStep(1);
        </script>

        <style>
            input[type="checkbox"]:checked {
                background-color: #4BA095;
                border-color: #4BA095;
            }

            input[type="radio"]:checked+div {
                border-color: #4BA095;
                background-color: rgba(75, 160, 149, 0.05);
            }
        </style>
    </x-layout>
