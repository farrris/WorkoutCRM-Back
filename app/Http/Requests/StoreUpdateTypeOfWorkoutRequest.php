<?php

namespace App\Http\Requests;

use App\Abstract\WorkoutOnlineFormRequest;

class StoreUpdateTypeOfWorkoutRequest extends WorkoutOnlineFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "title" => ["required", "string", "unique:types_of_workout"],
            "description" => ["string"]
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'Type of workout already exists',
        ];
    }
}
