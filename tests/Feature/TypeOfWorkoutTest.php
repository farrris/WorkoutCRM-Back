<?php

namespace Tests\Feature;

use App\Models\TypeOfWorkout;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TypeOfWorkoutTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected TypeOfWorkout $type_of_workout;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create(["email" => "cyutht3t.30@gmail.com", "password" => "4522307"]);
        $this->type_of_workout = TypeOfWorkout::create(["title" => "test title", "description" => "test description"]);
        Auth::login($this->user);
    }

    public function test_get_all_types_of_workout(): void
    {
        $response = $this->get('api/v1/type-of-workout');

        $response->assertStatus(200);
    }

    public function test_get_type_of_workout(): void
    {
        $response = $this->get("api/v1/type-of-workout/{$this->type_of_workout->id}");

        $response->assertStatus(200);
    }

    public function test_type_of_workout_not_found(): void
    {
        $response = $this->get("api/v1/type-of-workout/999");

        $response->assertStatus(404);
    }

    public function test_create_type_of_workout(): void
    {
        $data = [
            "title" => "other test title",
            "description" => "other test description"
        ];

        $response = $this->post('api/v1/type-of-workout', $data);

        $response->assertStatus(201);
    }

    public function test_update_type_of_workout(): void
    {
        $data = [
            "title" => "update test title",
            "description" => "update test description"
        ];


        $response = $this->put("api/v1/type-of-workout/{$this->type_of_workout->id}", $data);

        $response->assertStatus(200);
    }

    public function test_delete_type_of_workout(): void
    {
        $response = $this->delete("api/v1/type-of-workout/{$this->type_of_workout->id}");

        $response->assertStatus(200);
    }
}
