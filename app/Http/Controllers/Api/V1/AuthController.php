<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\ProfileService;
use App\Services\ResponseService;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function __construct(
        protected UserService $userService,
        protected ProfileService $profileService
    ) {
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $credentials = ["email" => $validated["email"], "password" => $validated["password"]];

        $token = Auth::attempt($credentials);
        if (!$token) {
            return ResponseService::unauthorized();
        } else {
            return ResponseService::success([
                "user" => Auth::user(),
                "authorization" => [
                    "token" => $token,
                    "type" => "bearer"
                ],
            ]);
        }
    }

    public function register(RegisterRequest $request)
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
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer'
                ]
            ],
            'User created successfully'
        );
    }

    public function logout()
    {
        Auth::logout();
        return ResponseService::success(
            [],
            'Successfully logged out'
        );
    }

    public function refresh()
    {
        return ResponseService::success(
            [
                'user' => Auth::user(),
                'authorisation' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ]
            ],
        );
    }

    public function protected()
    {
        return ResponseService::success(
            [
                'user' => Auth::user()
            ]
        );
    }
}
