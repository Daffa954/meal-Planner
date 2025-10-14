<x-layout>

@section('title', 'Daftar Resep - Meal Planner')
<x-navbar-user></x-navbar-user>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Daftar Resep</h1>
                <p class="text-gray-600 mt-2">Resep yang sudah digenerate dan disimpan</p>
            </div>
            
        </div>

        @if($recipes->isEmpty())
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🍽️</div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada resep</h3>
            <p class="text-gray-600 mb-6">Generate resep pertama Anda dengan AI</p>
            <a href="{{ route('recipes.generate') }}" 
               class="bg-[#4BA095] text-white px-6 py-3 rounded-lg hover:bg-[#3a887d] transition font-semibold">
                Generate Resep Pertama
            </a>
        </div>
        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recipes as $recipe)
            <div class="bg-white rounded-2xl shadow-sm border hover:shadow-md transition">
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $recipe->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $recipe->description }}</p>
                    
                    <div class="space-y-3">
                        <!-- Nutrition Info -->
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>🔥 {{ $recipe->nutrition->calories ?? 0 }} kkal</div>
                                <div>🍚 {{ $recipe->nutrition->carb ?? 0}}g karbo</div>
                                <div>🥚 {{ $recipe->nutrition->protein ?? 0}}g protein</div>
                                <div>🥑 {{ $recipe->nutrition->total_fat ?? 0}}g lemak</div>
                                <div>🍋 {{ $recipe->nutrition->saturated_fat ?? 0}}g lemak jenuhkal</div>
                                
                            </div>
                        </div>
                        
                        <!-- Cooking Info -->
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>⏱ {{ $recipe->time }}m</span>
                            <span>🍽 {{ $recipe->portion }} porsi</span>
                            <span>⚖️ {{ $recipe->weight }}g</span>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="mt-4 flex space-x-2">
                        <button onclick="showRecipeDetails({{ $recipe }})"
                                class="flex-1 bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-gray-200 transition text-sm">
                            👁️ Detail
                        </button>
                        <button onclick="addToMealPlan({{ $recipe->id }})"
                                class="flex-1 bg-[#4BA095] text-white py-2 rounded-lg hover:bg-[#3a887d] transition text-sm">
                            ➕ Tambah
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<script>
function showRecipeDetails(recipe) {
    let ingredientsList = '';
    recipe.ingredients.forEach(ingredient => {
        ingredientsList += `<li>• ${ingredient}</li>`;
    });
    
    let stepsList = '';
    recipe.step.forEach((step, index) => {
        stepsList += `<li>${index + 1}. ${step}</li>`;
    });

    Swal.fire({
        title: recipe.name,
        html: `
            <div class="text-left">
                <p class="text-gray-600 mb-4">${recipe.description}</p>
                
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <h4 class="font-semibold mb-2">📊 Informasi Gizi</h4>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div>Kalori: <strong>${recipe.nutrition.calories} kkal</strong></div>
                        <div>Karbohidrat: <strong>${recipe.nutrition.carb}g</strong></div>
                        <div>Protein: <strong>${recipe.nutrition.protein}g</strong></div>
                        <div>Lemak Total: <strong>${recipe.nutrition.total_fat}g</strong></div>
                        <div>Lemak Jenuh: <strong>${recipe.nutrition.saturated_fat}g</strong></div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h4 class="font-semibold mb-2">🛒 Bahan-bahan:</h4>
                    <ul class="text-sm space-y-1">${ingredientsList}</ul>
                </div>
                
                <div class="mb-4">
                    <h4 class="font-semibold mb-2">👩‍🍳 Cara Membuat:</h4>
                    <ol class="text-sm space-y-2">${stepsList}</ol>
                </div>
                
                <div class="flex justify-between text-sm text-gray-500">
                    <span>⏱ ${recipe.time} menit</span>
                    <span>🍽 ${recipe.portion} porsi</span>
                    <span>⚖️ ${recipe.weight} gram</span>
                </div>
            </div>
        `,
        width: 600,
        confirmButtonColor: '#4BA095'
    });
}

function addToMealPlan(recipeId) {
    Swal.fire({
        title: 'Tambahkan ke Meal Plan?',
        text: "Pilih anak dan waktu makan untuk resep ini",
        icon: 'question',
        confirmButtonColor: '#4BA095',
        showCancelButton: true,
        confirmButtonText: 'Tambahkan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implement add to meal plan logic
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Resep telah ditambahkan ke meal plan',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}
</script>
</x-layout>