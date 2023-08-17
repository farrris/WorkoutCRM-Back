<?php

namespace App\Services;

use App\Models\TypeOfWorkout;

class TypeOfWorkoutService
{
    public function index()
    {
        return TypeOfWorkout::all();
    }

    public function store($data)
    {
        $type_of_workout = TypeOfWorkout::create([
            "title" => $data["title"],
            "description" => array_key_exists("description", $data) ? $data["description"] : NULL
        ]);

        return $type_of_workout;
    }

    public function update(TypeOfWorkout $typeOfWorkout, $data)
    {
        $typeOfWorkout->update([
            "title" => $data["title"],
            "description" => array_key_exists("description", $data) ? $data["description"] : NULL
        ]);

        return $typeOfWorkout;
    }

    public function destroy(TypeOfWorkout $typeOfWorkout)
    {
        $typeOfWorkout->delete();
    }
}
