<?php

use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// SEMUA ROUTE AUTH DI SATU GROUP
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Children
    Route::get('/children/create', [ChildrenController::class, 'create'])->name('children.create');
    Route::post('/children', [ChildrenController::class, 'store'])->name('children.store');
    
    // Recipes - HAPUS DUPLIKASI
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/generate', [RecipeController::class, 'showGenerateForm'])->name('recipes.generate');
    Route::post('/recipes/generate', [RecipeController::class, 'generateRecipe'])->name('recipes.generate.submit');
    Route::post('/recipes/save-only', [RecipeController::class, 'saveRecipeOnly'])->name('recipes.save.only');
    Route::post('/recipes/save-and-add', [RecipeController::class, 'saveAndAddToMealPlan'])->name('recipes.save.and.add');
    Route::post('/recipes/save', [RecipeController::class, 'saveRecipe'])->name('recipes.save');
    
    // Meal Plans
    Route::get('/meal-plans/create', [MealPlanController::class, 'create'])->name('meal-plans.create');
    Route::post('/meal-plans', [MealPlanController::class, 'store'])->name('meal-plans.store');
    Route::get('/meal-plans', [MealPlanController::class, 'index'])->name('meal-plans.index');
    
    // Other Pages
    Route::get('/progress', function () {
        return view('progress');
    })->name('progress');
    
    Route::get('/shopping-list', function () {
        return view('shopping-list');
    })->name('shopping-list');
    
    Route::get('/favorites', function () {
        return view('favorites');
    })->name('favorites');
});

require __DIR__ . '/auth.php';