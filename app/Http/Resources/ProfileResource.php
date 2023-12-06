<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "age" => $this->age,
            "gender" => $this->gender,
            "sports_experience" => $this->sports_experience,
            "sports_level" => $this->sports_level,
            "kind_of_sport" => KindOfSportResource::make($this->kindOfSport),
            "food_type" => $this->food_type,
            "training_days" => $this->training_days,
            "work_experience" => $this->work_experience,
            "rate_per_hour" => $this->rate_per_hour
        ];
    }
}
