<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Children;
use App\Models\Recipe;
use App\Models\MealPlan;
use App\Models\MealPlanRecipe;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MealPlanController extends Controller
{
    public function create(Request $request)
    {
        $childId = $request->query('child_id');

        // Validasi child_id
        if (!$childId) {
            return redirect()->route('children.index')->with('error', 'Pilih anak terlebih dahulu');
        }

        $child = Children::find($childId);

        if (!$child) {
            return redirect()->route('children.index')->with('error', 'Data anak tidak ditemukan');
        }

        // Ambil resep yang tersedia
        $recipes = Recipe::with('nutrition')->get();

        // Generate dates untuk 7 hari ke depan
        $weekDates = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->addDays($i);
            $weekDates[] = [
                'date' => $date->format('Y-m-d'),
                'date_formatted' => $date->format('d M Y'),
                'day_name' => $date->translatedFormat('l')
            ];
        }

        // Waktu makan dengan default time
        $mealTimes = [
            'breakfast' => [
                'label' => 'Sarapan',
                'default_time' => '07:00'
            ],
            'lunch' => [
                'label' => 'Makan Siang',
                'default_time' => '12:00'
            ],
            'dinner' => [
                'label' => 'Makan Malam',
                'default_time' => '18:00'
            ],
            'snack' => [
                'label' => 'Camilan',
                'default_time' => '15:00'
            ]
        ];

        return view('mealplansCreate', compact(
            'child',
            'recipes',
            'weekDates',
            'mealTimes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'child_id' => 'required|exists:childrens,id',
            'date' => 'required|date',
            'meal_plans' => 'required|array',
            'meal_plans.*.type' => 'required|in:breakfast,lunch,dinner,snack',
            'meal_plans.*.time' => 'required|date_format:H:i',
            'meal_plans.*.recipe_id' => 'required|exists:recipes,id'
        ]);

        try {
            // Cek apakah sudah ada meal plan untuk tanggal dan child ini
            $existingMealPlan = MealPlan::where('child_id', $request->child_id)
                ->where('date', $request->date)
                ->first();

            if ($existingMealPlan) {
                // Hapus meal plan recipes yang lama
                MealPlanRecipe::where('meal_plan_id', $existingMealPlan->id)->delete();
                $mealPlan = $existingMealPlan;
            } else {
                // Buat meal plan baru
                $mealPlan = MealPlan::create([
                    'child_id' => $request->child_id,
                    'date' => $request->date,
                ]);
            }

            // Simpan meal plan recipes
            foreach ($request->meal_plans as $mealPlanData) {
                if (!empty($mealPlanData['recipe_id'])) {
                    MealPlanRecipe::create([
                        'meal_plan_id' => $mealPlan->id,
                        'recipe_id' => $mealPlanData['recipe_id'],
                        'type' => $mealPlanData['type'],
                        'time' => $mealPlanData['time'],
                        'status' => 'pending'
                    ]);
                }
            }

            return redirect()->route('meal-plans.index')
                ->with('success', 'Meal plan berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // public function index()
    // {
    //     $mealPlans = MealPlan::with(['children', 'mealPlanRecipes.recipe.nutrition'])
    //         ->orderBy('date', 'desc')
    //         ->get();

    //     return view('meal-plans.index', compact('mealPlans'));
    // }
    public function index()
{
    $mealPlans = MealPlan::with(['children', 'recipes.nutrition'])
        ->whereHas('children', function($query) {
            $query->where('user_id', auth()->id());
        })
        ->orderBy('date', 'desc')
        ->paginate(10); // Ganti get() dengan paginate()

    return view('mealplansIndex', compact('mealPlans'));
}
}