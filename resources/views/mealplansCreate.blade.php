<x-layout>
    @section('title', 'Buat Meal Plan - Meal Planner')
<x-navbar-user></x-navbar-user>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Buat Meal Plan</h1>
                        <p class="text-gray-600 mt-2">Rencanakan menu makanan untuk
                            <span class="font-semibold text-[#4BA095]">{{ $child->name }}</span>
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" id="generateRecipeBtn"
                            class="bg-[#7B5E3C] text-white px-6 py-3 rounded-lg hover:bg-[#6a4f32] transition font-semibold flex items-center">
                            🎯 Generate Resep Baru
                        </button>
                        <a href=""
                            class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition font-semibold">
                            ← Kembali
                        </a>
                    </div>
                </div>

                <!-- Credit Info -->
                
            </div>

            <!-- Meal Plan Form -->
            <div class="bg-white rounded-2xl shadow-sm border p-6">
                <form id="mealPlanForm" action="{{ route('meal-plans.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="child_id" value="{{ $child->id }}">
                    <input type="date" id="selected_date_input" name="date" class="mb-6">

                    <!-- Meal Times Container -->
                    <div id="mealTimesContainer" class="space-y-6">
                        <!-- Meal time akan ditambahkan secara dinamis di sini -->
                    </div>

                    <!-- Add Meal Time Button -->
                    <div class="mt-6">
                        <button type="button" id="addMealTimeBtn"
                            class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition font-semibold flex items-center">
                            ➕ Tambah Waktu Makan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Daily Summary -->
            <div class="mt-8 p-6 bg-[#4BA095] text-white rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Ringkasan Harian</h3>
                <div class="grid grid-cols-4 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold daily-total-calories">0</div>
                        <div>Total Kalori</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold daily-total-carb">0</div>
                        <div>Karbohidrat (g)</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold daily-total-protein">0</div>
                        <div>Protein (g)</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold daily-total-fat">0</div>
                        <div>Lemak (g)</div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href=""
                    class="bg-gray-500 text-white px-8 py-3 rounded-lg hover:bg-gray-600 transition font-semibold">
                    Batal
                </a>
                <button type="submit" form="mealPlanForm"
                    class="bg-[#4BA095] text-white px-8 py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold">
                    💾 Simpan Meal Plan
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Generate Resep -->
    <div id="generateModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Generate Resep dengan AI</h3>
                    <button type="button" id="closeModalBtn" class="text-gray-400 hover:text-gray-600 text-2xl">
                        &times;
                    </button>
                </div>

                <!-- Generate Form -->
                <form id="generateForm">
                    @csrf
                    <input type="hidden" name="child_id" value="{{ $child->id }}">
                    <input type="hidden" id="meal_type" name="meal_type">

                    <!-- Meal Type -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Jenis Makanan</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @php
                                $mealTypes = [
                                    'breakfast' => ['icon' => '🍳', 'label' => 'Sarapan'],
                                    'lunch' => ['icon' => '🍲', 'label' => 'Makan Siang'],
                                    'dinner' => ['icon' => '🍛', 'label' => 'Makan Malam'],
                                    'snack' => ['icon' => '🍎', 'label' => 'Camilan'],
                                ];
                            @endphp
                            @foreach ($mealTypes as $value => $info)
                                <label class="relative">
                                    <input type="radio" name="meal_type" value="{{ $value }}"
                                        class="sr-only peer" required>
                                    <div
                                        class="p-3 border-2 border-gray-200 rounded-lg text-center cursor-pointer peer-checked:border-[#4BA095] peer-checked:bg-[#4BA095]/5 transition">
                                        <div class="text-2xl mb-1">{{ $info['icon'] }}</div>
                                        <span class="font-medium text-sm">{{ $info['label'] }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Available Ingredients -->
                    <div class="mb-6">
                        <label for="available_ingredients" class="block text-sm font-medium text-gray-700 mb-2">
                            Bahan yang Tersedia (opsional)
                        </label>
                        <textarea id="available_ingredients" name="available_ingredients" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                            placeholder="Contoh: nasi, ayam, wortel, brokoli, telur, tahu... (pisahkan dengan koma)"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika ingin AI memilih bahan yang sesuai</p>
                    </div>

                    <!-- Additional Notes -->
                    <div class="mb-6">
                        <label for="additional_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan (opsional)
                        </label>
                        <textarea id="additional_notes" name="additional_notes" rows="2"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4BA095] focus:border-transparent transition"
                            placeholder="Contoh: anak suka makanan berkuah, hindari pedas, dll..."></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button type="button" id="cancelGenerateBtn"
                            class="flex-1 bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition font-semibold">
                            Batal
                        </button>
                        <button type="submit" id="generateButton"
                            class="flex-1 bg-[#4BA095] text-white py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold flex items-center justify-center">
                            <span id="buttonText">🎯 Generate Resep</span>
                            <span id="loadingSpinner" class="hidden ml-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Recipe Preview Area (Akan ditampilkan setelah generate) -->
                <div id="recipePreview" class="mt-6 mb-6 bg-white rounded-2xl shadow-sm border p-6 hidden">
                    <!-- Konten preview akan diisi via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Meal Times Data
        const mealTimeOptions = {
            'breakfast': {
                label: 'Sarapan',
                default_time: '07:00'
            },
            'lunch': {
                label: 'Makan Siang',
                default_time: '12:00'
            },
            'dinner': {
                label: 'Makan Malam',
                default_time: '18:00'
            },
            'snack': {
                label: 'Camilan',
                default_time: '15:00'
            },
            'morning_snack': {
                label: 'Camilan Pagi',
                default_time: '10:00'
            },
            'afternoon_snack': {
                label: 'Camilan Sore',
                default_time: '16:00'
            },
            'evening_snack': {
                label: 'Camilan Malam',
                default_time: '20:00'
            }
        };

        let mealTimeCounter = 0;
        let currentGeneratedRecipe = null;

        // Function untuk menambah meal time
        // Function untuk menambah meal time - VERSI DIPERBAIKI
function addMealTime(selectedType = '', selectedTime = '', selectedRecipe = '') {
    const container = document.getElementById('mealTimesContainer');
    const mealTimeId = `meal_time_${mealTimeCounter++}`;

    // Get available types (exclude yang sudah dipilih di meal time LAIN)
    const usedTypes = Array.from(document.querySelectorAll('.meal-time-type'))
        .map(select => select.value)
        .filter(value => value !== '' && value !== selectedType); // Exclude current selected type

    const availableTypes = Object.keys(mealTimeOptions).filter(type => !usedTypes.includes(type));

    // Jika tidak ada jenis tersisa DAN ini bukan edit existing item, tampilkan warning
    if (availableTypes.length === 0 && !selectedType) {
        Swal.fire({
            icon: 'warning',
            title: 'Tidak ada jenis makanan tersisa',
            text: 'Semua jenis makanan sudah ditambahkan',
            confirmButtonColor: '#4BA095'
        });
        return;
    }

    const mealTimeHtml = `
        <div class="border rounded-lg p-6 meal-time-item" id="${mealTimeId}">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Waktu Makan</h3>
                    <p class="text-sm text-gray-600">Atur waktu dan resep untuk makan ini</p>
                </div>
                <div class="flex space-x-2">
                    <button type="button" 
                            data-meal-time-id="${mealTimeId}"
                            class="generate-meal-btn bg-[#4BA095] text-white px-4 py-2 rounded-lg hover:bg-[#3a887d] transition font-semibold flex items-center text-sm">
                        🎯 Generate Resep
                    </button>
                    <button type="button" 
                            onclick="removeMealTime('${mealTimeId}')"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition font-semibold flex items-center text-sm">
                        🗑️ Hapus
                    </button>
                </div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Meal Type Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Makanan</label>
                    <select name="meal_plans[${mealTimeId}][type]" 
                            class="meal-time-type w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent" required>
                        <option value="">Pilih Jenis</option>
                        ${Object.entries(mealTimeOptions)
                            .map(([key, value]) => {
                                const isUsed = usedTypes.includes(key) && selectedType !== key;
                                const isSelected = selectedType === key;
                                return `
                                    <option value="${key}" 
                                        ${isSelected ? 'selected' : ''} 
                                        ${isUsed ? 'disabled' : ''}>
                                        ${value.label}
                                    </option>
                                `;
                            })
                            .join('')}
                    </select>
                </div>

                <!-- Time Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Makan</label>
                    <input type="time" 
                           name="meal_plans[${mealTimeId}][time]"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent"
                           value="${selectedTime || getDefaultTime(selectedType)}"
                           required>
                </div>

                <!-- Recipe Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Resep</label>
                    <div class="space-y-2">
                        <select name="meal_plans[${mealTimeId}][recipe_id]" 
                                class="recipe-select w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4BA095] focus:border-transparent">
                            <option value="">Pilih Resep</option>
                            @foreach ($recipes as $recipe)
                            <option value="{{ $recipe->id }}" 
                                    data-calories="{{ $recipe->nutrition->calories ?? 0 }}"
                                    data-carb="{{ $recipe->nutrition->carb ?? 0 }}"
                                    data-protein="{{ $recipe->nutrition->protein ?? 0 }}"
                                    data-fat="{{ $recipe->nutrition->total_fat ?? 0 }}"
                                    ${selectedRecipe == '{{ $recipe->id }}' ? 'selected' : ''}>
                                {{ $recipe->name }} ({{ $recipe->nutrition->calories ?? 0 }} kkal)
                            </option>
                            @endforeach
                        </select>
                        
                        <!-- Nutrition Preview -->
                        <div class="nutrition-preview text-xs text-gray-600 mt-2 hidden">
                            <div class="grid grid-cols-2 gap-1">
                                <span>🔥 <span class="calories">0</span> kkal</span>
                                <span>🍚 <span class="carb">0</span>g</span>
                                <span>🥚 <span class="protein">0</span>g</span>
                                <span>🥑 <span class="fat">0</span>g</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', mealTimeHtml);

    // Add event listeners untuk elemen yang baru ditambahkan
    const newMealTime = document.getElementById(mealTimeId);
    const recipeSelect = newMealTime.querySelector('.recipe-select');
    const typeSelect = newMealTime.querySelector('.meal-time-type');
    const generateBtn = newMealTime.querySelector('.generate-meal-btn');

    recipeSelect.addEventListener('change', function() {
        updateNutritionPreview(this);
        updateDailySummary();
    });

    typeSelect.addEventListener('change', function() {
        // Update default time berdasarkan jenis makanan
        const selectedType = this.value;
        if (selectedType && mealTimeOptions[selectedType]) {
            const timeInput = this.closest('.meal-time-item').querySelector('input[type="time"]');
            timeInput.value = mealTimeOptions[selectedType].default_time;
        }

        // Update generate button data-type
        generateBtn.setAttribute('data-type', selectedType);
        
        // Update semua dropdown type untuk sinkronisasi
        updateAllMealTypeDropdowns();
    });

    generateBtn.addEventListener('click', function() {
        const mealType = this.getAttribute('data-type') || typeSelect.value;
        if (mealType) {
            showGenerateModalForMeal(mealType);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Jenis Makanan',
                text: 'Pilih jenis makanan terlebih dahulu sebelum generate resep',
                confirmButtonColor: '#4BA095'
            });
        }
    });

    // Initialize nutrition preview jika ada resep yang dipilih
    if (selectedRecipe) {
        recipeSelect.dispatchEvent(new Event('change'));
    }

    updateAddButtonState();
}

// Helper function untuk mendapatkan default time
function getDefaultTime(mealType) {
    if (mealType && mealTimeOptions[mealType]) {
        return mealTimeOptions[mealType].default_time;
    }
    return '12:00';
}

// Function untuk update semua dropdown type
function updateAllMealTypeDropdowns() {
    const allTypeSelects = document.querySelectorAll('.meal-time-type');
    const allUsedTypes = Array.from(allTypeSelects)
        .map(select => select.value)
        .filter(value => value !== '');

    allTypeSelects.forEach(select => {
        const currentValue = select.value;
        
        Array.from(select.options).forEach(option => {
            if (option.value === '') return; // Skip placeholder
            
            const isUsed = allUsedTypes.includes(option.value) && option.value !== currentValue;
            const isCurrent = option.value === currentValue;
            
            if (isUsed && !isCurrent) {
                option.disabled = true;
            } else {
                option.disabled = false;
            }
        });
    });
}
        // Function untuk menghapus meal time
        function removeMealTime(mealTimeId) {
            const mealTimeElement = document.getElementById(mealTimeId);
            if (mealTimeElement) {
                mealTimeElement.remove();
                updateDailySummary();
                updateAddButtonState();
            }
        }

        // Function untuk update state tombol tambah
        function updateAddButtonState() {
            const addButton = document.getElementById('addMealTimeBtn');
            const usedTypes = Array.from(document.querySelectorAll('.meal-time-type'))
                .map(select => select.value)
                .filter(value => value !== '');

            const availableTypes = Object.keys(mealTimeOptions).filter(type => !usedTypes.includes(type));

            if (availableTypes.length === 0) {
                addButton.disabled = true;
                addButton.classList.add('opacity-50', 'cursor-not-allowed');
                addButton.classList.remove('hover:bg-green-600');
            } else {
                addButton.disabled = false;
                addButton.classList.remove('opacity-50', 'cursor-not-allowed');
                addButton.classList.add('hover:bg-green-600');
            }
        }

        // Modal Functions
        window.showGenerateModal = function() {
            console.log('showGenerateModal called');
            document.getElementById('generateModal').classList.remove('hidden');
            document.getElementById('meal_type').value = '';
            // Reset form
            document.getElementById('generateForm').reset();
            // Hide recipe preview
            document.getElementById('recipePreview').classList.add('hidden');
        }

        window.showGenerateModalForMeal = function(mealType) {
            console.log('showGenerateModalForMeal called', mealType);
            document.getElementById('generateModal').classList.remove('hidden');
            document.getElementById('meal_type').value = mealType;

            // Auto-select meal type
            const mealTypeInput = document.querySelector(`input[name="meal_type"][value="${mealType}"]`);
            if (mealTypeInput) {
                mealTypeInput.checked = true;
            }

            // Hide recipe preview
            document.getElementById('recipePreview').classList.add('hidden');
        }

        window.hideGenerateModal = function() {
            console.log('hideGenerateModal called');
            document.getElementById('generateModal').classList.add('hidden');
            // Reset loading state
            resetGenerateButton();
        }

        // Reset generate button state
        function resetGenerateButton() {
            const button = document.getElementById('generateButton');
            const buttonText = document.getElementById('buttonText');
            const loadingSpinner = document.getElementById('loadingSpinner');

            button.disabled = false;
            buttonText.textContent = '🎯 Generate Resep';
            loadingSpinner.classList.add('hidden');
        }

        // Update nutrition preview
        function updateNutritionPreview(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const preview = selectElement.parentElement.querySelector('.nutrition-preview');

            if (selectedOption.value && selectedOption.dataset.calories > 0) {
                preview.classList.remove('hidden');
                preview.querySelector('.calories').textContent = selectedOption.dataset.calories;
                preview.querySelector('.carb').textContent = selectedOption.dataset.carb;
                preview.querySelector('.protein').textContent = selectedOption.dataset.protein;
                preview.querySelector('.fat').textContent = selectedOption.dataset.fat;
            } else {
                preview.classList.add('hidden');
            }
        }

        // Update daily summary
        function updateDailySummary() {
            let totalCalories = 0;
            let totalCarb = 0;
            let totalProtein = 0;
            let totalFat = 0;

            document.querySelectorAll('.recipe-select').forEach(select => {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption.value && selectedOption.dataset.calories) {
                    totalCalories += parseInt(selectedOption.dataset.calories);
                    totalCarb += parseInt(selectedOption.dataset.carb);
                    totalProtein += parseInt(selectedOption.dataset.protein);
                    totalFat += parseInt(selectedOption.dataset.fat);
                }
            });

            document.querySelector('.daily-total-calories').textContent = totalCalories;
            document.querySelector('.daily-total-carb').textContent = totalCarb;
            document.querySelector('.daily-total-protein').textContent = totalProtein;
            document.querySelector('.daily-total-fat').textContent = totalFat;
        }

        // Function untuk menampilkan recipe preview
        function showRecipePreview(recipeData, targetType) {
            const preview = document.getElementById('recipePreview');
            preview.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">✨ Resep Hasil Generate</h3>
                    <button type="button" onclick="hideRecipePreview()"
                        class="text-gray-400 hover:text-gray-600 text-lg">
                        &times;
                    </button>
                </div>

                <div class="grid lg:grid-cols-2 gap-6">
                    <!-- Recipe Details -->
                    <div class="space-y-4">
                        <div class="text-center p-4 bg-gradient-to-r from-[#4BA095] to-[#7B5E3C] rounded-lg text-white">
                            <h4 class="font-bold text-lg">${recipeData.name}</h4>
                            <p class="text-sm opacity-90">${recipeData.description}</p>
                        </div>

                        <!-- Nutrition Info -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h5 class="font-semibold text-gray-900 mb-2">📊 Informasi Gizi</h5>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>Kalori: <strong>${recipeData.nutrition.calories}</strong> kkal</div>
                                <div>Karbohidrat: <strong>${recipeData.nutrition.carbohydrate}</strong>g</div>
                                <div>Protein: <strong>${recipeData.nutrition.protein}</strong>g</div>
                                <div>Lemak Total: <strong>${recipeData.nutrition.total_fat}</strong>g</div>
                                <div>Lemak Jenuh: <strong>${recipeData.nutrition.saturated_fat}</strong>g</div>
                            </div>
                        </div>

                        <!-- Cooking Info -->
                        <div class="flex justify-between text-sm text-gray-600 bg-gray-50 rounded-lg p-3">
                            <span>⏱ ${recipeData.time} menit</span>
                            <span>🍽 ${recipeData.portion} porsi</span>
                            <span>⚖️ ${recipeData.weight}g</span>
                        </div>
                    </div>

                    <!-- Ingredients & Steps -->
                    <div class="space-y-4">
                        <!-- Ingredients -->
                        <div>
                            <h5 class="font-semibold text-gray-900 mb-2">🛒 Bahan-bahan:</h5>
                            <ul class="text-sm space-y-1 bg-gray-50 rounded-lg p-3">
                                ${recipeData.ingredients.map(ingredient => 
                                    `<li class="flex items-start">
                                                        <span class="text-[#4BA095] mr-2">•</span>
                                                        <span>${ingredient}</span>
                                                    </li>`
                                ).join('')}
                            </ul>
                        </div>

                        <!-- Steps -->
                        <div>
                            <h5 class="font-semibold text-gray-900 mb-2">👩‍🍳 Cara Membuat:</h5>
                            <ol class="text-sm space-y-2 bg-gray-50 rounded-lg p-3">
                                ${recipeData.steps.map((step, index) => 
                                    `<li class="flex items-start">
                                                        <span class="font-semibold text-[#4BA095] mr-2">${index + 1}.</span>
                                                        <span>${step}</span>
                                                    </li>`
                                ).join('')}
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex space-x-3">
                    <button type="button" onclick="addToMealPlanAndSave('${targetType}')"
                        class="flex-1 bg-[#4BA095] text-white py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold">
                        ➕ Simpan Resep
                    </button>
                    
                    <button type="button" onclick="cancelRecipe()"
                        class="flex-1 bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition font-semibold">
                        ✕ Batal
                    </button>
                </div>
            `;

            preview.classList.remove('hidden');
            currentGeneratedRecipe = {
                ...recipeData,
                meal_type: targetType
            };
        }

        function hideRecipePreview() {
            document.getElementById('recipePreview').classList.add('hidden');
        }

        // Function untuk menyimpan resep saja
        window.saveRecipeOnly = function() {
            if (!currentGeneratedRecipe) return;

            Swal.fire({
                title: 'Simpan Resep?',
                text: "Resep akan disimpan ke daftar resep Anda",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#7B5E3C',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Sedang menyimpan resep',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request untuk save recipe only
                    fetch('{{ route('recipes.save.only') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(currentGeneratedRecipe)
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.close();
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    confirmButtonColor: '#4BA095',
                                    timer: 2000
                                });
                                hideRecipePreview();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message,
                                    confirmButtonColor: '#4BA095'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menyimpan resep' + error,
                                confirmButtonColor: '#4BA095'
                            });
                        });
                }
            });
        }

     
        window.addToMealPlanAndSave = function(targetType) {
            if (!currentGeneratedRecipe) {
                console.error('No generated recipe found');
                return;
            }

            console.log('🟡 Starting addToMealPlanAndSave for type:', targetType);
            console.log('Recipe data:', currentGeneratedRecipe);

            const recipeData = {
                name: currentGeneratedRecipe.name,
                description: currentGeneratedRecipe.description,
                ingredients: Array.isArray(currentGeneratedRecipe.ingredients) ?
                    currentGeneratedRecipe.ingredients : [currentGeneratedRecipe.ingredients],
                steps: Array.isArray(currentGeneratedRecipe.steps) ?
                    currentGeneratedRecipe.steps : [currentGeneratedRecipe.steps],
                time: parseInt(currentGeneratedRecipe.time) || 30,
                portion: parseInt(currentGeneratedRecipe.portion) || 1,
                weight: parseInt(currentGeneratedRecipe.weight) || 100,
                calories: parseFloat(currentGeneratedRecipe.nutrition?.calories) || 0,
                carbohydrate: parseFloat(currentGeneratedRecipe.nutrition?.carbohydrate) || 0,
                protein: parseFloat(currentGeneratedRecipe.nutrition?.protein) || 0,
                total_fat: parseFloat(currentGeneratedRecipe.nutrition?.total_fat) || 0,
                saturated_fat: parseFloat(currentGeneratedRecipe.nutrition?.saturated_fat) || 0,
                meal_type: targetType || currentGeneratedRecipe.meal_type || 'dinner',
                child_id: '{{ $child->id }}'
            };

            console.log('📤 Sending data to server:', recipeData);

            Swal.fire({
                title: 'Tambahkan ke Meal Plan?',
                text: "Resep akan disimpan dan langsung tersedia di dropdown",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4BA095',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tambahkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Sedang menyimpan resep',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request
                    fetch('{{ route('recipes.save.and.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(recipeData)
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Server response:', data);
                            Swal.close();

                            if (data.success) {
                                // AUTO-UPDATE DROPDOWN: Tambahkan resep baru ke semua dropdown
                                addRecipeToDropdowns(
                                    data.recipe_id,
                                    data.recipe_name || recipeData.name,
                                    recipeData.calories,
                                    recipeData.carbohydrate,
                                    recipeData.protein,
                                    recipeData.total_fat
                                );

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message ||
                                        'Resep berhasil disimpan dan sudah tersedia di dropdown!',
                                    confirmButtonColor: '#4BA095',
                                    timer: 2000
                                });

                                hideRecipePreview();
                                hideGenerateModal();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message || 'Terjadi kesalahan saat menyimpan resep',
                                    confirmButtonColor: '#4BA095'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan jaringan: ' + error.message,
                                confirmButtonColor: '#4BA095'
                            });
                        });
                }
            });
        }

        // Function untuk menambahkan resep baru ke semua dropdown
        function addRecipeToDropdowns(recipeId, recipeName, calories, carb, protein, fat) {
            // Cari semua dropdown recipe-select
            const recipeSelects = document.querySelectorAll('.recipe-select');

            recipeSelects.forEach(select => {
                // Cek apakah resep sudah ada di dropdown ini
                const existingOption = Array.from(select.options).find(opt => opt.value == recipeId);

                if (!existingOption) {
                    // Buat option baru
                    const newOption = document.createElement('option');
                    newOption.value = recipeId;
                    newOption.textContent = `${recipeName} (${calories} kkal)`;
                    newOption.dataset.calories = calories;
                    newOption.dataset.carb = carb;
                    newOption.dataset.protein = protein;
                    newOption.dataset.fat = fat;

                    // Tambahkan ke dropdown (setelah option pertama)
                    select.appendChild(newOption);

                    console.log(`✅ Resep ditambahkan ke dropdown: ${recipeName}`);
                }
            });
        }


        // Event Listeners ketika DOM sudah fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');

            // Initialize selected date
            updateSelectedDate();

            // Event listener untuk date selection
            document.querySelectorAll('.date-radio').forEach(radio => {
                radio.addEventListener('change', function() {
                    updateSelectedDate();
                });
            });

            // Event listener untuk tombol tambah meal time
            const addMealTimeBtn = document.getElementById('addMealTimeBtn');
            if (addMealTimeBtn) {
                addMealTimeBtn.addEventListener('click', function() {
                    addMealTime();
                });
            }

            // Event listener untuk tombol generate utama
            const generateRecipeBtn = document.getElementById('generateRecipeBtn');
            if (generateRecipeBtn) {
                generateRecipeBtn.addEventListener('click', function() {
                    showGenerateModal();
                });
            }

            // Event listener untuk tombol close modal
            const closeModalBtn = document.getElementById('closeModalBtn');
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', function() {
                    hideGenerateModal();
                });
            }

            // Event listener untuk tombol cancel generate
            const cancelGenerateBtn = document.getElementById('cancelGenerateBtn');
            if (cancelGenerateBtn) {
                cancelGenerateBtn.addEventListener('click', function() {
                    hideGenerateModal();
                });
            }

            // Generate form submission dengan AJAX
            document.getElementById('generateForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const targetType = document.getElementById('meal_type').value;

                // Credit validation

                // Loading state
                const button = document.getElementById('generateButton');
                const buttonText = document.getElementById('buttonText');
                const loadingSpinner = document.getElementById('loadingSpinner');

                button.disabled = true;
                buttonText.textContent = 'Generating...';
                loadingSpinner.classList.remove('hidden');

                // AJAX request
                fetch('{{ route('recipes.generate.submit') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        resetGenerateButton();

                        if (data.success) {
                            // Tampilkan recipe preview dalam modal
                            showRecipePreview(data.recipe, targetType);
                            currentGeneratedRecipe = data.recipe;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Generate Gagal',
                                text: data.message,
                                confirmButtonColor: '#4BA095'
                            });
                        }
                    })
                    .catch(error => {
                        resetGenerateButton();
                        console.error('Error details:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error mmm',
                            text: 'Terjadi kesalahan saat generate resep' + error,
                            confirmButtonColor: '#4BA095'
                        });
                    });
            });

            // Meal plan form submission
            document.getElementById('mealPlanForm').addEventListener('submit', function(e) {
                const hasMeals = Array.from(document.querySelectorAll('.recipe-select'))
                    .some(select => select.value !== '');

                if (!hasMeals) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak ada resep dipilih',
                        text: 'Pilih setidaknya satu resep untuk meal plan',
                        confirmButtonColor: '#4BA095'
                    });
                }
            });

            // Tambahkan meal time default
            addMealTime('breakfast', '07:00');
            addMealTime('lunch', '12:00');
            addMealTime('dinner', '18:00');
        });

        // Update selected date
        function updateSelectedDate() {
            const selectedDate = document.querySelector('input[name="selected_date"]:checked');
            if (selectedDate) {
                document.getElementById('selected_date_input').value = selectedDate.value;
            }
        }
    </script>
</x-layout>
