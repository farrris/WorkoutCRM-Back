<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTypeOfWorkoutRequest;
use App\Http\Resources\TypeOfWorkoutResource;
use App\Models\TypeOfWorkout;
use App\Services\ResponseService;
use App\Services\TypeOfWorkoutService;

class TypeOfWorkoutController extends Controller
{

    public function __construct(protected TypeOfWorkoutService $typeOfWorkoutService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types_of_workout = $this->typeOfWorkoutService->index();
        return ResponseService::success([
            "types_of_workout" => TypeOfWorkoutResource::collection($types_of_workout)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateTypeOfWorkoutRequest $request)
    {
        $validated = $request->validated();

        $type_of_workout = $this->typeOfWorkoutService->store($validated);

        return ResponseService::сreated(
            [
                "type_of_workout" => TypeOfWorkoutResource::make($type_of_workout)
            ],
            "Type of workout successful created"
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeOfWorkout $typeOfWorkout)
    {
        return ResponseService::success([
            "type_of_workout" => TypeOfWorkoutResource::make($typeOfWorkout)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateTypeOfWorkoutRequest $request, TypeOfWorkout $typeOfWorkout)
    {
        $validated = $request->validated();

        $type_of_workout = $this->typeOfWorkoutService->update($typeOfWorkout, $validated);

        return ResponseService::success(
            [
                "type_of_workout" => TypeOfWorkoutResource::make($type_of_workout)
            ],
            "Type of workout successful updated"
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeOfWorkout $typeOfWorkout)
    {
        $type_of_workout = $this->typeOfWorkoutService->destroy($typeOfWorkout);

        return ResponseService::success(
            message: "type of workout succesful deleted"
        );
    }
}
