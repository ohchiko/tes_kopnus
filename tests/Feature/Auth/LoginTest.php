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
}
