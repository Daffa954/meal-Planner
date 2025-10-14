<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    /** @use HasFactory<\Database\Factories\ChildrenFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'age_years',
        'age_months',
        'gender',
        'weight',
        'height',
        
    ];

    protected $casts = [
        'weight' => 'float',
        'height' => 'float',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function preference()
    {
        return $this->hasOne(Preference::class);
    }
    
    public function mealPlans()
    {
        return $this->hasMany(MealPlan::class, 'child_id');
    }
}
