<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JokiRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'rank_name',
        'type',
        'price_per_star',
    ];
}