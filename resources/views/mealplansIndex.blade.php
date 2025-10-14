<x-layout>
    @section('title', 'Meal Plans - Meal Planner')
    <x-navbar-user></x-navbar-user>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Meal Plans</h1>
                        <p class="text-gray-600 mt-2">Kelola rencana makanan untuk anak Anda</p>
                    </div>

                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6">
                <div class="flex flex-wrap gap-4 items-center ">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Tanggal</label>
                        <input type="date" id="dateFilter"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4BA095]">
                    </div>
                    <div class=" ">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Anak</label>
                        <select id="childFilter"
                            class="border w-[200px] border-gray-300 rounded-lg flex  px-3 mr-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#4BA095]">
                            <option value="" class="text-sm">Semua Anak</option>
                            <!-- Option akan diisi via JavaScript -->
                        </select>
                    </div>
                    <div class="">
                        <p class="mb-2 text-transparent md:block hidden">hello</p>
                        <button id="resetFilter"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition font-semibold">
                            🔄 Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Meal Plans List -->
            <div class="space-y-6">
                @forelse($mealPlans as $mealPlan)
                    <div class="bg-white rounded-2xl shadow-sm border p-6 meal-plan-item"
                        data-date="{{ $mealPlan->date }}" data-child="{{ $mealPlan->children->name }}">
                        <!-- Meal Plan Header -->
                        <div class="flex md:justify-between gap-2 md:flex-nowrap flex-wrap items-start mb-6">
                            <div>
                                <div class="flex items-center space-x-3 mb-2">
                                    <h2 class="md:text-2xl text-xl font-bold text-gray-900">
                                        {{ $mealPlan->date }}
                                    </h2>
                                    <span
                                        class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ $mealPlan->children->name }}
                                    </span>
                                </div>
                                <p class="text-gray-600">
                                    {{ $mealPlan->date }} •
                                    {{ $mealPlan->recipes->count() }} resep
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                {{-- <button onclick="editMealPlan({{ $mealPlan->id }})"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition font-semibold text-sm">
                                    ✏️ Edit
                                </button>
                                <button onclick="deleteMealPlan({{ $mealPlan->id }})"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition font-semibold text-sm">
                                    🗑️ Hapus
                                </button> --}}
                            </div>
                        </div>

                        <!-- Daily Nutrition Summary -->
                        @php
                            $totalCalories = 0;
                            $totalProtein = 0;
                            $totalCarb = 0;
                            $totalFat = 0;

                            foreach ($mealPlan->recipes as $recipe) {
                                if ($recipe->nutrition) {
                                    $totalCalories += $recipe->nutrition->calories;
                                    $totalProtein += $recipe->nutrition->protein;
                                    $totalCarb += $recipe->nutrition->carb;
                                    $totalFat += $recipe->nutrition->total_fat;
                                }
                            }
                        @endphp

                        <div class="bg-gradient-to-r from-[#4BA095] to-[#7B5E3C] rounded-lg p-4 text-white mb-6">
                            <h3 class="font-semibold mb-3">📊 Ringkasan Gizi Harian</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold">{{ $totalCalories }}</div>
                                    <div class="text-sm opacity-90">Total Kalori</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold">{{ $totalCarb }}g</div>
                                    <div class="text-sm opacity-90">Karbohidrat</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold">{{ $totalProtein }}g</div>
                                    <div class="text-sm opacity-90">Protein</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold">{{ $totalFat }}g</div>
                                    <div class="text-sm opacity-90">Lemak</div>
                                </div>
                            </div>
                        </div>

                        <!-- Recipes Grid -->
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($mealPlan->recipes as $recipe)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-lg">{{ $recipe->name }}</h4>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span
                                                    class="bg-[#4BA095] text-white px-2 py-1 rounded text-xs font-semibold">
                                                    {{ $recipe->pivot->type }}
                                                </span>
                                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">
                                                    {{ $recipe->pivot->time }}
                                                </span>
                                                <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">
                                                    {{ $recipe->pivot->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex space-x-1">
                                            {{-- <button
                                                onclick="markAsCompleted({{ $mealPlan->id }}, {{ $recipe->id }})"
                                                class="text-green-600 hover:text-green-800 text-lg"
                                                title="Tandai selesai">
                                                ✓
                                            </button>
                                            <button onclick="removeRecipe({{ $mealPlan->id }}, {{ $recipe->id }})"
                                                class="text-red-600 hover:text-red-800 text-lg"
                                                title="Hapus dari meal plan">
                                                ×
                                            </button> --}}
                                        </div>
                                    </div>

                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        {{ $recipe->description }}
                                    </p>

                                    <!-- Cooking Info -->
                                    <div class="flex justify-between text-xs text-gray-500 mb-3">
                                        <span>⏱ {{ $recipe->time }} menit</span>
                                        <span>🍽 {{ $recipe->portion }} porsi</span>
                                        <span>⚖️ {{ $recipe->weight }}g</span>
                                    </div>

                                    <!-- Nutrition Info -->
                                    @if ($recipe->nutrition)
                                        <div class="bg-gray-50 rounded-lg p-3">
                                            <h5 class="font-semibold text-gray-900 text-sm mb-2">Informasi Gizi:</h5>
                                            <div class="grid grid-cols-2 gap-2 text-xs">
                                                <div class="flex items-center">
                                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                                    <span>{{ $recipe->nutrition->calories }} kkal</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                                    <span>{{ $recipe->nutrition->protein }}g protein</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                                    <span>{{ $recipe->nutrition->carb }}g karbo</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                                    <span>{{ $recipe->nutrition->total_fat }}g lemak</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Detail Button -->
                                    <div class="mt-3">
                                        <button onclick="showRecipeDetail({{ $recipe->id }})"
                                            class="text-[#4BA095] hover:text-[#3a887d] text-sm font-semibold flex items-center">
                                            📋 Lihat Detail
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-8">
                                    <div class="text-gray-400 text-6xl mb-4">🍽️</div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada resep</h3>
                                    <p class="text-gray-600 mb-4">Tambahkan resep ke meal plan ini untuk memulai.</p>
                                    <a href="{{ route('meal-plans.create') }}?child_id={{ $mealPlan->child_id }}&date={{ $mealPlan->date }}"
                                        class="bg-[#4BA095] text-white px-6 py-2 rounded-lg hover:bg-[#3a887d] transition font-semibold inline-flex items-center">
                                        ➕ Tambah Resep
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="bg-white rounded-2xl shadow-sm border p-12 text-center">
                        <div class="text-gray-400 text-8xl mb-6">📅</div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Belum ada Meal Plan</h2>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Mulai buat meal plan pertama Anda untuk mengatur makanan anak dengan lebih terstruktur dan
                            bergizi.
                        </p>
                        <a href="{{ route('children.index') }}"
                            class="bg-[#4BA095] text-white px-8 py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold inline-flex items-center text-lg">
                            🎯 Buat Meal Plan Pertama
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($mealPlans->hasPages())
                <div class="mt-8">
                    {{ $mealPlans->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Resep -->
    <div id="recipeDetailModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900" id="modalRecipeName">Detail Resep</h3>
                    <button type="button" onclick="closeRecipeDetail()"
                        class="text-gray-400 hover:text-gray-600 text-2xl">
                        &times;
                    </button>
                </div>

                <div id="recipeDetailContent">
                    <!-- Konten detail akan diisi via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data recipes untuk modal detail
        const recipesData = {
            @foreach ($mealPlans ?? [] as $mealPlan)
                @foreach ($mealPlan->recipes as $recipe)
                    {{ $recipe->id }}: {
                        name: `{{ $recipe->name }}`,
                        description: `{{ $recipe->description }}`,
                        time: {{ $recipe->time }},
                        portion: {{ $recipe->portion }},
                        weight: {{ $recipe->weight }},
                        meal_type: `{{ $recipe->meal_type }}`,
                        ingredients: @json($recipe->ingredients ?? []),
                        steps: @json($recipe->step ?? []),
                        nutrition: @json($recipe->nutrition ?? null),
                        pivot: {
                            type: `{{ $recipe->pivot->type }}`,
                            time: `{{ $recipe->pivot->time }}`,
                            status: `{{ $recipe->pivot->status }}`
                        }
                    },
                @endforeach
            @endforeach
        };

        // Filter Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dateFilter = document.getElementById('dateFilter');
            const childFilter = document.getElementById('childFilter');
            const resetFilter = document.getElementById('resetFilter');
            const mealPlanItems = document.querySelectorAll('.meal-plan-item');

            // Populate child filter options
            const children = Array.from(mealPlanItems).map(item => ({
                name: item.dataset.child,
                value: item.dataset.child
            })).filter((child, index, self) =>
                index === self.findIndex(c => c.value === child.value)
            );

            children.forEach(child => {
                const option = document.createElement('option');
                option.value = child.value;
                option.textContent = child.name;
                childFilter.appendChild(option);
            });

            // Filter function
            function applyFilters() {
                const selectedDate = dateFilter.value;
                const selectedChild = childFilter.value;

                mealPlanItems.forEach(item => {
                    const itemDate = item.dataset.date;
                    const itemChild = item.dataset.child;

                    const dateMatch = !selectedDate || itemDate === selectedDate;
                    const childMatch = !selectedChild || itemChild === selectedChild;

                    if (dateMatch && childMatch) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            // Event listeners
            dateFilter.addEventListener('change', applyFilters);
            childFilter.addEventListener('change', applyFilters);

            resetFilter.addEventListener('click', function() {
                dateFilter.value = '';
                childFilter.value = '';
                applyFilters();
            });
        });

        // Show recipe detail modal
        function showRecipeDetail(recipeId) {
            const recipe = recipesData[recipeId];
            if (!recipe) {
                console.error('Recipe not found:', recipeId);
                return;
            }

            // Update modal title
            document.getElementById('modalRecipeName').textContent = recipe.name;

            // Build modal content
            let modalContent = `
                <div class="space-y-6">
                    <!-- Header Info -->
                    <div class="bg-gradient-to-r from-[#4BA095] to-[#7B5E3C] rounded-lg p-4 text-white">
                        <h4 class="font-bold text-lg mb-2">${recipe.name}</h4>
                        <p class="text-white/90">${recipe.description}</p>
                    </div>

                    <!-- Meal Info Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-[#4BA095]">${recipe.time}</div>
                            <div class="text-sm text-gray-600">Menit</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-[#7B5E3C]">${recipe.portion}</div>
                            <div class="text-sm text-gray-600">Porsi</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-[#F5B947]">${recipe.weight}</div>
                            <div class="text-sm text-gray-600">Gram</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-lg font-bold text-[#E76F51] capitalize">${recipe.pivot.type}</div>
                            <div class="text-sm text-gray-600">Jenis</div>
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-6">
                        <!-- Ingredients Section -->
                        <div>
                            <h5 class="font-semibold text-gray-900 text-lg mb-3 flex items-center">
                                <span class="mr-2">🛒</span> Bahan-bahan
                            </h5>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <ul class="space-y-2">
            `;

            // Add ingredients
            if (recipe.ingredients && recipe.ingredients.length > 0) {
                recipe.ingredients.forEach(ingredient => {
                    modalContent += `
                        <li class="flex items-start">
                            <span class="text-[#4BA095] mr-2 mt-1">•</span>
                            <span class="text-gray-700">${ingredient}</span>
                        </li>
                    `;
                });
            } else {
                modalContent += `<li class="text-gray-500">Tidak ada bahan yang tercantum</li>`;
            }

            modalContent += `
                                </ul>
                            </div>
                        </div>

                        <!-- Nutrition Section -->
                        <div>
                            <h5 class="font-semibold text-gray-900 text-lg mb-3 flex items-center">
                                <span class="mr-2">📊</span> Informasi Gizi
                            </h5>
                            <div class="bg-gray-50 rounded-lg p-4">
            `;

            // Add nutrition info
            if (recipe.nutrition) {
                modalContent += `
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-sm font-medium">Kalori:</span>
                            <span class="text-sm ml-auto font-bold">${recipe.nutrition.calories} kkal</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <span class="text-sm font-medium">Protein:</span>
                            <span class="text-sm ml-auto font-bold">${recipe.nutrition.protein}g</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm font-medium">Karbohidrat:</span>
                            <span class="text-sm ml-auto font-bold">${recipe.nutrition.carb}g</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                            <span class="text-sm font-medium">Lemak Total:</span>
                            <span class="text-sm ml-auto font-bold">${recipe.nutrition.total_fat}g</span>
                        </div>
                    </div>
                `;
            } else {
                modalContent += `<p class="text-gray-500 text-sm">Informasi gizi tidak tersedia</p>`;
            }

            modalContent += `
                            </div>
                        </div>
                    </div>

                    <!-- Steps Section -->
                    <div>
                        <h5 class="font-semibold text-gray-900 text-lg mb-3 flex items-center">
                            <span class="mr-2">👩‍🍳</span> Cara Membuat
                        </h5>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <ol class="space-y-3">
            `;

            // Add steps
            if (recipe.steps && recipe.steps.length > 0) {
                recipe.steps.forEach((step, index) => {
                    modalContent += `
                        <li class="flex items-start">
                            <span class="bg-[#4BA095] text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5 flex-shrink-0">
                                ${index + 1}
                            </span>
                            <span class="text-gray-700">${step}</span>
                        </li>
                    `;
                });
            } else {
                modalContent += `<li class="text-gray-500">Tidak ada langkah yang tercantum</li>`;
            }

            modalContent += `
                            </ol>
                        </div>
                    </div>

                    <!-- Schedule Info -->
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h5 class="font-semibold text-gray-900 text-lg mb-2 flex items-center">
                            <span class="mr-2">⏰</span> Jadwal dalam Meal Plan
                        </h5>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-600">Waktu:</span>
                                <span class="ml-2 font-bold">${recipe.pivot.time}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Status:</span>
                                <span class="ml-2 font-bold capitalize ${recipe.pivot.status === 'completed' ? 'text-green-600' : 'text-orange-600'}">
                                    ${recipe.pivot.status}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Update modal content
            document.getElementById('recipeDetailContent').innerHTML = modalContent;

            // Show modal
            document.getElementById('recipeDetailModal').classList.remove('hidden');
        }

        // Close recipe detail modal
        function closeRecipeDetail() {
            document.getElementById('recipeDetailModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('recipeDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRecipeDetail();
            }
        });

        // Mark recipe as completed
        function markAsCompleted(mealPlanId, recipeId) {
            Swal.fire({
                title: 'Tandai selesai?',
                text: "Resep akan ditandai sebagai sudah diselesaikan",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4BA095',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tandai Selesai',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX request to update status
                    fetch(`/meal-plans/${mealPlanId}/recipes/${recipeId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: 'completed'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Resep ditandai sebagai selesai',
                                    confirmButtonColor: '#4BA095',
                                    timer: 1500
                                });
                                setTimeout(() => location.reload(), 1600);
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Gagal memperbarui status',
                                confirmButtonColor: '#4BA095'
                            });
                        });
                }
            });
        }

        // Remove recipe from meal plan
        function removeRecipe(mealPlanId, recipeId) {
            Swal.fire({
                title: 'Hapus resep?',
                text: "Resep akan dihapus dari meal plan ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX request to remove recipe
                    fetch(`/meal-plans/${mealPlanId}/recipes/${recipeId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: 'Resep berhasil dihapus dari meal plan',
                                    confirmButtonColor: '#4BA095',
                                    timer: 1500
                                });
                                setTimeout(() => location.reload(), 1600);
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Gagal menghapus resep',
                                confirmButtonColor: '#4BA095'
                            });
                        });
                }
            });
        }

        // Edit meal plan
        function editMealPlan(mealPlanId) {
            window.location.href = `/meal-plans/create?edit=${mealPlanId}`;
        }

        // Delete meal plan
        function deleteMealPlan(mealPlanId) {
            Swal.fire({
                title: 'Hapus meal plan?',
                text: "Semua resep dalam meal plan ini akan dihapus",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX request to delete meal plan
                    fetch(`/meal-plans/${mealPlanId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: 'Meal plan berhasil dihapus',
                                    confirmButtonColor: '#4BA095',
                                    timer: 1500
                                });
                                setTimeout(() => location.reload(), 1600);
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Gagal menghapus meal plan',
                                confirmButtonColor: '#4BA095'
                            });
                        });
                }
            });
        }
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layout>
