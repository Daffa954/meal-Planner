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
                    <div class="flex space-x-3">
                        <a href="{{ route('meal-plans.create') }}?child_id={{ request('child_id') }}"
                            class="bg-[#4BA095] text-white px-6 py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold flex items-center">
                            ➕ Buat Meal Plan Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6">
                <div class="flex flex-wrap gap-4 items-center">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Tanggal</label>
                        <input type="date" id="dateFilter"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4BA095]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Anak</label>
                        <select id="childFilter"
                            class="border border-gray-300 rounded-lg px- py-2 focus:outline-none focus:ring-2 focus:ring-[#4BA095]">
                            <option value="" class="mr-5">Semua Anak</option>
                            <!-- Option akan diisi via JavaScript -->
                        </select>
                    </div>
                    <div class="flex items-end">
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
                                <button onclick="editMealPlan({{ $mealPlan->id }})"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition font-semibold text-sm">
                                    ✏️ Edit
                                </button>
                                <button onclick="deleteMealPlan({{ $mealPlan->id }})"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition font-semibold text-sm">
                                    🗑️ Hapus
                                </button>
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
                                            <button
                                                onclick="markAsCompleted({{ $mealPlan->id }}, {{ $recipe->id }})"
                                                class="text-green-600 hover:text-green-800 text-lg"
                                                title="Tandai selesai">
                                                ✓
                                            </button>
                                            <button onclick="removeRecipe({{ $mealPlan->id }}, {{ $recipe->id }})"
                                                class="text-red-600 hover:text-red-800 text-lg"
                                                title="Hapus dari meal plan">
                                                ×
                                            </button>
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

                                    <!-- Ingredients Preview -->
                                    <div class="mt-3">
                                        <button onclick="toggleIngredients({{ $recipe->id }})"
                                            class="text-[#4BA095] hover:text-[#3a887d] text-sm font-semibold flex items-center">
                                            🛒 Lihat Bahan-bahan
                                            <svg class="w-4 h-4 ml-1 transition-transform" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div id="ingredients-{{ $recipe->id }}"
                                            class="hidden mt-2 text-xs text-gray-600">
                                            <ul class="list-disc list-inside space-y-1">
                                                @if (is_array($recipe->ingredients))
                                                    @foreach (array_slice($recipe->ingredients, 0, 3) as $ingredient)
                                                        <li>{{ $ingredient }}</li>
                                                    @endforeach
                                                    @if (count($recipe->ingredients) > 3)
                                                        <li class="text-[#4BA095] font-semibold">
                                                            +{{ count($recipe->ingredients) - 3 }} bahan lainnya</li>
                                                    @endif
                                                @else
                                                    <li>Bahan tidak tersedia</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-8">
                                    <div class="text-gray-400 text-6xl mb-4">🍽️</div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada resep</h3>
                                    <p class="text-gray-600 mb-4">Tambahkan resep ke meal plan ini untuk memulai.</p>
                                    <a href="{{ route('meal-plans.create') }}?child_id={{ $mealPlan->child_id }}&date={{ $mealPlan->dat }}"
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
                        <a href="{{ route('meal-plans.create') }}"
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

    <script>
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

        // Toggle ingredients visibility
      // Toggle ingredients visibility - FIXED VERSION
function toggleIngredients(recipeId) {
    const ingredientsDiv = document.getElementById('ingredients-' + recipeId);
    
    if (!ingredientsDiv) {
        console.error('Ingredients div not found for recipe ID:', recipeId);
        return;
    }

    // Cari button yang diklik
    const button = ingredientsDiv.previousElementSibling;
    
    if (!button) {
        console.error('Button not found for recipe ID:', recipeId);
        return;
    }

    const icon = button.querySelector('svg');
    
    if (icon) {
        ingredientsDiv.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    } else {
        // Fallback jika SVG tidak ditemukan
        ingredientsDiv.classList.toggle('hidden');
    }
}

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

        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</x-layout>
