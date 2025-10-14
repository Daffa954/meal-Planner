<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    /** @use HasFactory<\Database\Factories\NutritionFactory> */
    use HasFactory;
    protected $fillable = [
        'recipe_id',
        'calories',
        'carb',
        'protein',
        'total_fat',
        'saturated_fat',
    ];
 // Relationship ke recipe
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
    
}
