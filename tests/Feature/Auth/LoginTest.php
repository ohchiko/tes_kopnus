<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()
            ->for(Role::factory())
            ->create([
                "email" => "gregorio@example.org",
                "password" => "password"
            ]);

        $response = $this->postJson(route("api.login"), [
            "email" => "gregorio@example.org",
            "password" => "password"
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                "data" => [
                    "token"
                ],
                "meta" => [
                    "message"
                ]
            ]);
    }

    public function test_user_can_request_with_api_token()
    {
        $user = User::factory()
            ->for(Role::factory())
            ->create([
                "email" => "gregorio@example.org",
                "password" => "password"
            ]);

        $loginResponse = $this->postJson(route("api.login"), [
            "email" => "gregorio@example.org",
            "password" => "password"
        ]);

        $loginResponse->assertOk();

        $token = $loginResponse->json("data.token");

        $response = $this->withHeader("Authorization", "Bearer {$token}")
            ->getJson(route("api.user"));

        $response->assertOk()
            ->assertJsonStructure([
                "data" => [
                    "user" => [
                        "id",
                        "role" => [
                            "id",
                            "name"
                        ],
                        "name",
                        "email"
                    ]
                ]
            ]);
    }
}
