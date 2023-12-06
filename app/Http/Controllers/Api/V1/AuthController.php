<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Services\ProfileService;
use App\Services\ResponseService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function __construct(
        protected UserService $userService,
        protected ProfileService $profileService
    ) {
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     operationId="login",
     *     tags={"Auth"},
     *     description="Метод для авторизации пользователя",
     *
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              @OA\Property(property="email",type="string",example="example@gmail.com"),
     *              @OA\Property(property="password",type="string",example="123456789"),
     *           ),
     *       ),
     *     ),
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="user",
     *                     ref="#/components/schemas/User"
     *                 ),
     *              )
     *          )
     *      )
     * )
     * 
     * @param LoginRequest
     * @return JsonResponse
     */

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $credentials = ["email" => $validated["email"], "password" => $validated["password"]];

        $token = Auth::attempt($credentials);
        if (!$token) {
            return ResponseService::unauthorized();
        } else {
            return ResponseService::success([
                "user" => UserResource::make(Auth::user()),
                "authorization" => [
                    "token" => $token,
                    "type" => "bearer"
                ],
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     operationId="register",
     *     tags={"Auth"},
     *     description="Метод для регистрации пользователя",
     *
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              @OA\Property(
     *                   property="user",
     *                   type="object",
     *                   @OA\Property(property="email",type="string", example="example@gmail.com"),
     *                   @OA\Property(property="password",type="string", example="123456789"),
     *                   @OA\Property(property="role", type="string", example="trainer")
     *              ),
     *              @OA\Property(
     *                   property="profile",
     *                   type="object",
     *                   @OA\Property(property="first_name",type="string", example="Alex"),
     *                   @OA\Property(property="last_name",type="string", example="Smirnov"),
     *                   @OA\Property(property="age",type="int64", example="23"),
     *                   @OA\Property(property="gender",type="string", example="male"),
     *                   @OA\Property(property="sports_experience",type="string", example="4 года"),
     *                   @OA\Property(property="sports_level",type="string", example="advanced"),
     *                   @OA\Property(property="kind_of_sport_id",type="int64", example="1"),
     *                   @OA\Property(property="food_type",type="string", example="cut"),
     *                   @OA\Property(property="training_days",type="array",
     *                                   @OA\Items(type="string"), 
     *                                   example={"monday", "wednesday", "friday"}),
     *                   @OA\Property(property="work_experience",type="string", example="1 год"),
     *                   @OA\Property(property="rate_per_hour",type="string", example="1000"),             
     *              ),
     *           ),
     *       ),
     *     ),
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="user",
     *                     ref="#/components/schemas/User"
     *                 ),
     *              )
     *          )
     *      )
     * )
     * 
     * @param RegisterRequest
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = DB::transaction(function () use ($validated) {
            $user = $this->userService->store($validated["user"]);
            $profile = $this->profileService->store($validated["profile"], $user);

            return $user;
        });

        $token = Auth::login($user);

        return ResponseService::сreated(
            [
                'user' => UserResource::make($user),
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer'
                ]
            ],
            'User created successfully'
        );
    }

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     operationId="logout",
     *     tags={"Auth"},
     *     description="Метод для выхода из системы",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *          response="200",
     *          description="OK",
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *      )
     * )
     * 
     * @return JsonResponse
     */

    public function logout(): JsonResponse
    {
        Auth::logout();
        return ResponseService::success(
            [],
            'Successfully logged out'
        );
    }

    /**
     * @OA\Post(
     *     path="/api/v1/refresh",
     *     operationId="refresh",
     *     tags={"Auth"},
     *     description="Метод для обновления jwt токенов пользователя",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="user",
     *                     ref="#/components/schemas/User"
     *                 ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *      )
     * )
     * 
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return ResponseService::success(
            [
                'user' => UserResource::make(Auth::user()),
                'authorisation' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ]
            ],
        );
    }

    /**
     * @OA\Get(
     *     path="/api/v1/protected",
     *     operationId="protected",
     *     tags={"Auth"},
     *     description="Метод для получения информации о текущем авторизованном пользователе или проверки авторизации",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="user",
     *                     ref="#/components/schemas/User"
     *                 ),
     *              )
     *          )
     *      ),
     *      
     * )
     * 
     * @return JsonResponse
     */
    public function protected(Request $request): JsonResponse
    {   
        return ResponseService::success(
            [
                'user' => UserResource::make(Auth::user()),
            ]
        );
    }
}
