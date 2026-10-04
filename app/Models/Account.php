<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'title',
        'game_type',
        'price',
        'old_price',
        'rank',
        'hero_count',
        'skin_count',
        'emblem_level',
        'emblem',
        'login_via',
        'minus',
        'description',
        'image',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}