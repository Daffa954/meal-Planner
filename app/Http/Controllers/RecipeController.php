<?php
// app/Http/Controllers/RecipeController.php



// app/Http/Controllers/RecipeController.php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\Recipe;
use App\Models\Nutrition;
use App\Models\MealPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecipeController extends Controller
{
    // Tampilkan form generate resep (untuk halaman terpisah)

    // Generate resep dengan AI - PERBAIKAN DI SINI
    // Tampilkan form generate resep (untuk halaman terpisah)


    // Tampilkan form generate resep (untuk halaman terpisah)
    public function showGenerateForm()
    {
        $children = Children::with('preference')->get();
        $selectedChildId = request('child_id');

        return view('recipes.generate', compact('children', 'selectedChildId'));
    }

    // Generate resep dengan AI - PERBAIKAN: Tidak langsung save
    public function generateRecipe(Request $request)
    {
        try {
            $request->validate([
                'child_id' => 'required|exists:childrens,id',
                'meal_type' => 'required|in:breakfast,lunch,dinner,snack,morning_snack,afternoon_snack,evening_snack',
                'available_ingredients' => 'nullable|string',
                'additional_notes' => 'nullable|string|max:500',
                'meal_type' => 'nullable|string'
            ]);

            // Get child data
            $child = Children::with('preference')->findOrFail($request->child_id);



            // Prepare data for AI
            $ageInMonths = ($child->age_years * 12) + $child->age_months;
            $allergens = $child->preference->allergens ?? [];
            $location = $child->preference->lokasi ?? 'Indonesia';
            $availableIngredients = $request->available_ingredients ? explode(',', $request->available_ingredients) : [];
            $mealType = $request->meal_type;
            $additionalNotes = $request->additional_notes;

            // Generate prompt
            $prompt = $this->createOptimizedPrompt(
                $ageInMonths,
                $location,
                $allergens,
                $availableIngredients,
                $mealType,
                $additionalNotes
            );

            // Call DeepSeek API
            $response = $this->callDeepSeekAPI($prompt);

            if (!$response->successful()) {
                throw new \Exception('Gagal menghubungi AI service');
            }

            $aiResponse = $response->json();
            $recipeData = $this->parseRecipeResponse($aiResponse);


            return response()->json([
                'success' => true,
                'recipe' => $recipeData,
                'message' => 'Resep berhasil digenerate!'
            ]);
        } catch (\Exception $e) {
            Log::error('Recipe generation error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    // Simpan resep setelah user memilih "Simpan Saja"
    // Simpan resep dan tambahkan ke meal plan
    public function saveAndAddToMealPlan(Request $request)
    {
        \Log::info('🎯 saveAndAddToMealPlan METHOD CALLED - START');
        \Log::info('Request data:', $request->all());

        try {
            // Get data dari request
            $data = $request->json()->all();
            \Log::info('📦 Received data for save and add:', $data);

            // Validasi
            $validator = \Validator::make($data, [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'ingredients' => 'required|array',
                'steps' => 'required|array',
                'time' => 'required|integer|min:1',
                'portion' => 'required|integer|min:1',
                'weight' => 'required|integer|min:1',
                'calories' => 'required|numeric|min:0',
                'carbohydrate' => 'required|numeric|min:0',
                'protein' => 'required|numeric|min:0',
                'total_fat' => 'required|numeric|min:0',
                'saturated_fat' => 'required|numeric|min:0',
                'meal_type' => 'required|string',
                'child_id' => 'required|exists:childrens,id',
            ]);

            if ($validator->fails()) {
                \Log::error('❌ Validation failed in saveAndAdd:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all()),
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }

            $validated = $validator->validated();
            \Log::info('✅ Validation passed for save and add');

            // SIMPAN RECIPE - dengan user_id dan meal_type
            $recipeData = [
                'name' => $validated['name'],
                'description' => $validated['description'],
                'ingredients' => $validated['ingredients'],
                'step' => $validated['steps'],
                'time' => $validated['time'],
                'portion' => $validated['portion'],
                'weight' => $validated['weight'],
                'meal_type' => $validated['meal_type'] ?: 'nasi', // SIMPAN meal_type
                'user_id' => auth()->id(), // SIMPAN user_id
            ];

            \Log::info('💾 Saving recipe:', $recipeData);

            $recipe = Recipe::create($recipeData);

            \Log::info('✅ Recipe created with ID: ' . $recipe->id);

            // SIMPAN NUTRITION
            $nutritionData = [
                'recipe_id' => $recipe->id,
                'calories' => $validated['calories'],
                'carb' => $validated['carbohydrate'],
                'protein' => $validated['protein'],
                'total_fat' => $validated['total_fat'],
                'saturated_fat' => $validated['saturated_fat'],
            ];

            \Log::info('💾 Saving nutrition:', $nutritionData);

            $nutrition = Nutrition::create($nutritionData);
            \Log::info('✅ Nutrition created with ID: ' . $nutrition->id);

            \Log::info('🎉 Recipe saved successfully for meal plan');

            return response()->json([
                'success' => true,
                'message' => 'Resep berhasil disimpan!',
                'recipe_id' => $recipe->id,
                'child_id' => $validated['child_id'],
                'meal_type' => $validated['meal_type']
            ]);

        } catch (\Exception $e) {
            \Log::error('💥 saveAndAddToMealPlan error: ' . $e->getMessage());
            \Log::error('File: ' . $e->getFile());
            \Log::error('Line: ' . $e->getLine());
            \Log::error('Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan resep: ' . $recipeData['meal_type']
            ], 500);
        }
    }

    // Simpan resep saja
    public function saveRecipeOnly(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'ingredients' => 'required|array',
                'steps' => 'required|array',
                'time' => 'required|integer',
                'portion' => 'required|integer',
                'weight' => 'required|integer',
                'calories' => 'required|numeric',
                'carbohydrate' => 'required|numeric',
                'protein' => 'required|numeric',
                'total_fat' => 'required|numeric',
                'saturated_fat' => 'required|numeric',
                'meal_type' => 'required|in:breakfast,lunch,dinner,snack,morning_snack,afternoon_snack,evening_snack'
            ]);

            // Create recipe - dengan user_id dan meal_type
            $recipe = Recipe::create([
                'name' => $request->name,
                'description' => $request->description,
                'ingredients' => $request->ingredients,
                'step' => $request->steps,
                'time' => $request->time,
                'portion' => $request->portion,
                'weight' => $request->weight,
                'meal_type' => $request->meal_type, // SIMPAN meal_type
                'user_id' => auth()->id(), // SIMPAN user_id
            ]);

            // Create nutrition
            Nutrition::create([
                'recipe_id' => $recipe->id,
                'calories' => $request->calories,
                'carb' => $request->carbohydrate,
                'protein' => $request->protein,
                'total_fat' => $request->total_fat,
                'saturated_fat' => $request->saturated_fat,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Resep berhasil disimpan!',
                'recipe_id' => $recipe->id
            ]);

        } catch (\Exception $e) {
            Log::error('Save recipe error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan resep: ' . $e->getMessage()
            ], 500);
        }
    }

    // Simpan resep dan tambahkan ke meal plan



    // Generate resep dengan AI - PERBAIKAN DI SINI

    // Simpan resep yang digenerate (untuk halaman terpisah)

    // List resep
    public function index()
    {
        $recipes = Recipe::with('nutrition')
            ->where('user_id', auth()->id()) // Hanya resep milik user yang login
            ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
            ->get();

        return view('listRecipe', compact('recipes'));
    }

    private function createOptimizedPrompt(
        int $ageInMonths,
        string $location,
        array $allergens,
        array $availableIngredients,
        string $mealType,
        string $additionalNotes = null
    ): string {
        $ageInYears = floor($ageInMonths / 12);
        $remainingMonths = $ageInMonths % 12;
        $ageDisplay = $ageInYears > 0 ? "{$ageInYears} tahun {$remainingMonths} bulan" : "{$remainingMonths} bulan";

        $mealTypeMap = [
            'breakfast' => 'sarapan',
            'lunch' => 'makan siang',
            'dinner' => 'makan malam',
            'snack' => 'camilan'
        ];

        return "Buatkan resep makanan dengan ketentuan:
- Untuk anak {$ageDisplay}
- Lokasi: {$location}
- Alergi: " . (count($allergens) > 0 ? implode(", ", $allergens) : "tidak ada") . "
- " . (count($availableIngredients) > 0 ? "Hanya gunakan bahan-bahan berikut: " . implode(", ", $availableIngredients) : "Bahan boleh bebas, asalkan mudah ditemukan di wilayah {$location} dan tidak termasuk alergen") . "
- apabila ada bahan dari alergi dan bahan tersedia sama jangan berikan resepnya
- Jenis makanan: {$mealTypeMap[$mealType]}
- " . ($additionalNotes ? "Catatan tambahan: {$additionalNotes}" : "") . "
- Jangan berikan resep yang terlalu umum seperti 'nasi goreng', 'mie goreng', atau 'telur dadar'
- Nama makanan jangan dengan nama lokasinya
- Berikan juga nutrisi dari makanan tersebut seperti calories dalam kkal dan carbohydrate, protein, total_fat, saturated_fat dalam gram
- Dalam bahasa Indonesia

Format output HARUS dalam JSON dengan struktur:
{
\"name\": \"string\",
\"description\": \"string\", 
\"ingredients\": [\"string\"],
\"steps\": [\"string\"],
\"time\": number,
\"portion\": number, 
\"weight\": number,
\"nutrition\": {
  \"calories\": number,
  \"carbohydrate\": number,
  \"protein\": number,
  \"total_fat\": number,
  \"saturated_fat\": number
}
}

Prioritas:
1. Keamanan (hindari alergen)
2. Nutrisi sesuai usia
3. Gunakan bahan lokal yang tersedia
4. Waktu masak efisien";
    }

    private function callDeepSeekAPI(string $prompt)
    {
        $apiKey = config('services.deepseek.api_key');
        $baseUrl = config('services.deepseek.base_url');

        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(60)->post($baseUrl . '/chat/completions', [
                    'model' => 'deepseek/deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 2000,
                    'response_format' => ['type' => 'json_object']
                ]);
    }

    private function parseRecipeResponse(array $aiResponse): array
    {
        try {
            if (!isset($aiResponse['choices'][0]['message']['content'])) {
                throw new \Exception('Respons AI tidak valid');
            }

            $content = $aiResponse['choices'][0]['message']['content'];

            // Extract JSON dari response
            $firstCurly = strpos($content, '{');
            $lastCurly = strrpos($content, '}');
            $jsonString = substr($content, $firstCurly, $lastCurly - $firstCurly + 1);

            $parsedData = json_decode($jsonString, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Gagal parsing JSON dari AI');
            }

            // Validasi struktur
            if (!isset($parsedData['name']) || !isset($parsedData['ingredients']) || !isset($parsedData['nutrition'])) {
                throw new \Exception('Struktur resep tidak lengkap');
            }

            return [
                'name' => $parsedData['name'],
                'description' => $parsedData['description'] ?? '',
                'ingredients' => $parsedData['ingredients'] ?? [],
                'steps' => $parsedData['steps'] ?? $parsedData['step'] ?? [],
                'time' => $parsedData['time'] ?? 0,
                'portion' => $parsedData['portion'] ?? 1,
                'weight' => $parsedData['weight'] ?? 0,
                'nutrition' => [
                    'calories' => $parsedData['nutrition']['calories'] ?? 0,
                    'carbohydrate' => $parsedData['nutrition']['carbohydrate'] ?? 0,
                    'protein' => $parsedData['nutrition']['protein'] ?? 0,
                    'total_fat' => $parsedData['nutrition']['total_fat'] ?? 0,
                    'saturated_fat' => $parsedData['nutrition']['saturated_fat'] ?? 0,
                ]
            ];

        } catch (\Exception $e) {
            Log::error('Parse recipe error: ' . $e->getMessage());
            throw new \Exception('Gagal memproses respons AI: ' . $e->getMessage());
        }
    }
}