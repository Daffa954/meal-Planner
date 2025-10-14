<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    /** @use HasFactory<\Database\Factories\MealPlanFactory> */
    use HasFactory;
    protected $fillable = [
        'child_id',
        'date',
    ];
     // Relationship dengan Child
    public function children()
    {
        return $this->belongsTo(Children::class, 'child_id');
    }

    // Relationship many-to-many dengan Recipe melalui pivot table
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'meal_plan_recipes')
                    ->withPivot('status', 'type', 'time')
                    ->withTimestamps();
    }

    // Alias untuk mealPlanRecipes (jika dibutuhkan)
    public function mealPlanRecipes()
    {
        return $this->belongsToMany(Recipe::class, 'meal_plan_recipes')
                    ->withPivot('status', 'type', 'time')
                    ->withTimestamps();
    }

    // Relationship langsung ke pivot table
    public function mealPlanRecipesPivot()
    {
        return $this->hasMany(MealPlanRecipe::class, 'meal_plan_id');
    }
}
