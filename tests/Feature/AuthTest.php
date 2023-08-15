<?php

namespace Tests\Feature;

use App\Enums\FoodTypeEnum;
use App\Enums\SportsLevelEnum;
use App\Enums\TrainingDaysEnum;
use App\Enums\UserGenderEnum;
use App\Enums\UserRoleEnum;
use App\Models\KindOfSport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_register_new_user(): void
    {

        KindOfSport::create(["title" => "football"]);

        $data = [
            "user" => [
                "email" => "cyutht3t.30@gmail.com",
                "password" => "123456789",
                "role" => UserRoleEnum::Athlete->value,
            ],
            "profile" => [
                "first_name" => "Ivan",
                "last_name" => "Ivanov",
                "age" => 20,
                "gender" => UserGenderEnum::Male->value,
                "sports_experience" => "3 years",
                "sports_level" => SportsLevelEnum::Beginner->value,
                "kind_of_sport_id" => 1,
                "food_type" => FoodTypeEnum::Maintenance->value,
                "training_days" => [TrainingDaysEnum::Monday->value, TrainingDaysEnum::Thursday->value]
            ]
        ];

        $response = $this->post('/api/v1/register', $data);

        $response->assertStatus(201);
    }

    public function test_login_user(): void
    {
        User::create(["email" => "cyutht3t.30@gmail.com", "password" => "123456789", "role" => "athlete"]);

        $data = [
            "email" => "cyutht3t.30@gmail.com",
            "password" => "123456789"
        ];

        $response = $this->post('/api/v1/login', $data);

        $response->assertStatus(200);
    }

    public function test_logout_user(): void
    {
        $user = User::create(["email" => "cyutht3t.30@gmail.com", "password" => "123456789", "role" => "athlete"]);
        $token = Auth::login($user);

        $response = $this->post("/api/v1/logout");

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_knocking_on_protected_route(): void
    {
        $response = $this->post("/api/v1/protected");

        $response->assertStatus(401);
    }
}
