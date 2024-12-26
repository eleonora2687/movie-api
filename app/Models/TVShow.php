<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TVShow extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'poster_url',
        'release_date',
        'categories',
        'rating',
        'overview',
        'is_favorite',
        'category', 
    ];

    // Casting categories to an array for easier manipulation
    protected $casts = [
        'categories' => 'array', // Automatically cast the 'categories' attribute to an array
    ];
}


