<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPlanRecipe extends Model
{
    /** @use HasFactory<\Database\Factories\MealPlanRecipeFactory> */
    use HasFactory;
    protected $fillable = [
        'meal_plan_id',
        'recipe_id',
        'type',
        'status',
        'time'
    ];

    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class, 'meal_plan_id', 'id');
    }

    // Relationship dengan Recipe
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }

}
