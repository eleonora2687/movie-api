<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'poster_url',
        'release_date',
        'categories',
        'duration',
        'rating',
        'is_favorite',
        'overview',
        'category', // Don't forget to include category in $fillable
    ];

    // Casting categories to an array for easier manipulation
    protected $casts = [
        'categories' => 'array', // Automatically cast the 'categories' attribute to an array
    ];
}

