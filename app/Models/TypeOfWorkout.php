<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfWorkout extends Model
{
    use HasFactory;

    protected $table = "types_of_workout";

    protected $fillable = [
        "title"
    ];
}
