<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\MealPlan;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Hitung stats yang real
        $stats = [
            'total_children' => $user->children()->count(),
            'active_plans' => MealPlan::whereHas('children', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('date', '>=', now()->format('Y-m-d'))->count(),
            'favorite_recipes' => Recipe::where('user_id', $user->id)->count(),
            'meals_this_week' => MealPlan::whereHas('children', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        // Data user
        $userData = [
            'greeting' => $this->getGreeting()
        ];

        // Quick actions
        $quickActions = [
            [
                'icon' => '🎯',
                'title' => 'Generate Meal Plan',
                'description' => 'Buat plan makanan baru',
                'route' => 'meal-plans.create',
                'color' => 'bg-[#4BA095] hover:bg-[#3a887d]'
            ],
            [
                'icon' => '📊',
                'title' => 'Lihat Progress',
                'description' => 'Track perkembangan anak',
                'route' => 'progress',
                'color' => 'bg-[#7B5E3C] hover:bg-[#6a4f32]'
            ],
            [
                'icon' => '🛒',
                'title' => 'Buat Shopping List',
                'description' => 'List belanja mingguan',
                'route' => 'shopping-list',
                'color' => 'bg-[#F5B947] hover:bg-[#e4a836]'
            ],
            [
                'icon' => '❤️',
                'title' => 'Resep Favorit',
                'description' => 'Resep yang disukai',
                'route' => 'favorites',
                'color' => 'bg-[#E76F51] hover:bg-[#d65e40]'
            ]
        ];

        // Data children dengan meal plan terakhir
        $children = $user->children()->get()->map(function($child) {
            $lastMealPlan = MealPlan::where('child_id', $child->id)
                ->orderBy('date', 'desc')
                ->first();
                
            return [
                'id' => $child->id,
                'name' => $child->name,
                'age' => $child->age_years . ' tahun ' . $child->age_months . ' bulan',
                'last_meal_plan' => $lastMealPlan ? $lastMealPlan->date : 'Belum ada'
            ];
        });

        // Data untuk kalender
        $mealPlans = MealPlan::with(['children', 'recipes' => function($query) {
            $query->withPivot('type', 'time');
        }])
        ->whereHas('children', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->whereBetween('date', [now()->subDays(30), now()->addDays(30)])
        ->get();

        return view('dashboard', compact('userData', 'stats', 'quickActions', 'children', 'mealPlans'));
    }

    private function getGreeting()
    {
        $hour = now()->hour;
        
        if ($hour < 12) {
            return 'Selamat pagi! Siap meal plan hari ini?';
        } elseif ($hour < 15) {
            return 'Selamat siang! Sudah makan siang belum?';
        } elseif ($hour < 19) {
            return 'Selamat sore! Waktunya merencanakan makan malam.';
        } else {
            return 'Selamat malam! Jangan lupa plan untuk besok.';
        }
    }
}