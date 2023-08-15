<?php

namespace App\Http\Requests;

use App\Abstract\WorkoutOnlineFormRequest;
use App\Enums\FoodTypeEnum;
use App\Enums\SportsLevelEnum;
use App\Enums\TrainingDaysEnum;
use App\Enums\UserGenderEnum;
use App\Enums\UserRoleEnum;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends WorkoutOnlineFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'user.password' => ['required', 'string', 'min:6'],
            'user.role' => ['required', 'string', new Enum(UserRoleEnum::class)],

            'profile.first_name' => ['required', 'string', 'max:255'],
            'profile.last_name' => ['required', 'string', 'max:255'],
            'profile.age' => ['required', 'int'],
            'profile.gender' => ['required', 'string', new Enum(UserGenderEnum::class)],
            'profile.sports_experience' => ['required', 'string'],
            'profile.sports_level' => ['required', 'string', new Enum(SportsLevelEnum::class)],
            'profile.kind_of_sport_id' => ['required', 'integer', 'exists:App\Models\KindOfSport,id'],
            'profile.food_type' => ['required', 'string', new Enum(FoodTypeEnum::class)],
            'profile.training_days' => ['required', 'array'],
            'profile.training_days.*' => ['required', 'string', new Enum(TrainingDaysEnum::class)],

            // for trainer profile
            'profile.work_experience' => ['string'],
            'profile.rate_per_hour' => ['numeric']

        ];
    }

    public function messages(): array
    {
        return [
            'user.email.unique' => 'User already exists',
        ];
    }
}
