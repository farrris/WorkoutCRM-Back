<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'age',
        'gender',
        'sports_experience',
        'sports_level',
        'kind_of_sport_id',
        'food_type',
        'training_days',
        'work_experience',
        'rate_per_hour'
    ];

    protected $casts = [
        "training_days" => "array"
    ];
}
