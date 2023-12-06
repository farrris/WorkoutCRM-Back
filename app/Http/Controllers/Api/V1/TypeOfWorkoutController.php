<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTypeOfWorkoutRequest;
use App\Http\Resources\TypeOfWorkoutResource;
use App\Models\TypeOfWorkout;
use App\Services\ResponseService;
use App\Services\TypeOfWorkoutService;
use Illuminate\Http\JsonResponse;

class TypeOfWorkoutController extends Controller
{

    public function __construct(protected TypeOfWorkoutService $typeOfWorkoutService)
    {
    }
    /**
     * @OA\Get(
     *     path="/api/v1/type-of-workout",
     *     operationId="typeOfWorkoutIndex",
     *     tags={"Type of workout"},
     *     description="Метод возвращает все типы тренировок",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="typeOfWorkout",
     *                      ref="#/components/schemas/TypeOfWorkout"
     *                 ),
     *              )
     *          ),
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $types_of_workout = $this->typeOfWorkoutService->index();
        return ResponseService::success([
            "types_of_workout" => TypeOfWorkoutResource::collection($types_of_workout)
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/type-of-workout/",
     *     operationId="typeOfWorkoutStore",
     *     tags={"Type of workout"},
     *     description="Метод создает тип тренировки",
     *     security={{"bearer_token":{}}},
     * 
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              @OA\Property(property="title",type="string",example="test title"),
     *              @OA\Property(property="description",type="string",example="test description"),
     *           ),
     *       ),
     *     ),
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="typeOfWorkout",
     *                      ref="#/components/schemas/TypeOfWorkout"
     *                 ),
     *              )
     *          )
     *      )
     * )
     * 
     * @param StoreUpdateTypeOfWorkoutRequest
     * @return JsonResponse
     */

    public function store(StoreUpdateTypeOfWorkoutRequest $request): JsonResponse
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
     * @OA\Get(
     *     path="/api/v1/type-of-workout/{id}",
     *     operationId="typeOfWorkoutShow",
     *     tags={"Type of workout"},
     *     description="Метод возвращает тип тренировки по id",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id типа тренировки",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="typeOfWorkout",
     *                      ref="#/components/schemas/TypeOfWorkout"
     *                 ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response="404",
     *          description="NOT FOUND"
     *      ),
     * )
     * 
     * @param TypeOfWorkout
     * 
     * @return JsonResponse
     */
    public function show(TypeOfWorkout $typeOfWorkout): JsonResponse
    {
        return ResponseService::success([
            "type_of_workout" => TypeOfWorkoutResource::make($typeOfWorkout)
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/type-of-workout/{id}",
     *     operationId="typeOfWorkoutUpdate",
     *     tags={"Type of workout"},
     *     description="Метод обновляет тип тренировки",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id типа тренировки",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              @OA\Property(property="title",type="string",example="test title"),
     *              @OA\Property(property="description",type="string",example="test description"),
     *           ),
     *       ),
     *     ),
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="typeOfWorkout",
     *                      ref="#/components/schemas/TypeOfWorkout"
     *                 ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response="404",
     *          description="NOT FOUND"
     *      ),
     * )
     * 
     * @param StoreUpdateTypeOfWorkoutRequest
     * @param TypeOfWorkout
     * 
     * @return JsonResponse
     */
    public function update(StoreUpdateTypeOfWorkoutRequest $request, TypeOfWorkout $typeOfWorkout): JsonResponse
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
     * @OA\Delete(
     *     path="/api/v1/type-of-workout/{id}",
     *     operationId="typeOfWorkoutDelete",
     *     tags={"Type of workout"},
     *     description="Метод удаляет тип тренировки по id",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="id типа тренировки",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(response="200",
     *          description="OK",
     *     ),
     *     @OA\Response(response="404",
     *          description="NOT FOUND"
     *     ),
     * )
     * 
     * @param TypeOfWorkout
     * 
     * @return JsonResponse
     */
    public function destroy(TypeOfWorkout $typeOfWorkout): JsonResponse
    {   
        $this->typeOfWorkoutService->destroy($typeOfWorkout);

        return ResponseService::success(
            message: "type of workout succesful deleted"
        );
    }
}
