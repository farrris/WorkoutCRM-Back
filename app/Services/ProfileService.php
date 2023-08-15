<?php

namespace App\Services;

use App\Enums\UserRoleEnum;
use App\Models\Profile;

class ProfileService
{
    public function store($data, $user)
    {
        $profile = Profile::create([
            "user_id" => $user->id,
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "age" => $data["age"],
            "gender" => $data["gender"],
            "sports_experience" => $data["sports_experience"],
            "sports_level" => $data["sports_level"],
            "kind_of_sport_id" => $data["kind_of_sport_id"],
            "food_type" => $data["food_type"],
            "training_days" => $data["training_days"],
            "work_experience" => $user->role == UserRoleEnum::Trainer->value ? $data["work_experience"] : NULL,
            "rate_per_hour" => $user->role == UserRoleEnum::Trainer->value ? $data["rate_per_hour"] : NULL,
        ]);

        return $profile;
    }
}
