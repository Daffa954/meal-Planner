<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    /** @use HasFactory<\Database\Factories\RecipeFactory> */
    use HasFactory;
     protected $fillable = [
        'name',
        'description', 
        'ingredients',
        'step',
        'time',
        'portion',
        'weight',
        'meal_type',
        'user_id',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'step' => 'array',
    ];
    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan Nutrition
    public function nutrition()
    {
        return $this->hasOne(Nutrition::class);
    }

    // Relationship many-to-many dengan MealPlan melalui pivot table
    public function mealPlans()
    {
        return $this->belongsToMany(MealPlan::class, 'meal_plan_recipes')
                    ->withPivot('status', 'type', 'time')
                    ->withTimestamps();
    }

    // Alias untuk mealPlanRecipes (jika dibutuhkan)
    public function mealPlanRecipes()
    {
        return $this->belongsToMany(MealPlan::class, 'meal_plan_recipes')
                    ->withPivot('status', 'type', 'time')
                    ->withTimestamps();
    }
}
