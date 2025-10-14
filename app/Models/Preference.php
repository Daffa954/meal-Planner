<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    /** @use HasFactory<\Database\Factories\PreferenceFactory> */
    use HasFactory;
    protected $fillable = [
        'children_id',
        'allergens',
        'favorite_foods',
        'lokasi',
    ];
    protected $casts = [
        'allergens' => 'array',
        'favorite_foods' => 'array',
        
    ];
}
