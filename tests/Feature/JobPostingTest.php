<?php

namespace Tests\Feature;

use App\Models\JobPosting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobPostingTest extends TestCase
{
    use RefreshDatabase;

    private function getToken(string $roleName = "client")
    {
        $dataUser = [
            "email" => "gregorio@example.org",
            "password" => "password"
        ];

        User::factory()
            ->for(
                Role::factory()
                    ->state(["name" => $roleName])
            )
            ->create($dataUser);

        $loginResponse = $this->postJson(route("api.login"), $dataUser);

        $loginResponse->assertOk();

        return $loginResponse->json("data.token");
    }

    public function test_client_can_create_job_posting_with_valid_data()
    {
        $token = $this->getToken("client");

        $response = $this->withHeader("Authorization", "Bearer {$token}")
            ->postJson(route("api.job-postings.store"), [
                "title" => "Membuat Website Freelancer",
                "description" => "Buatkan website freelancer",
                "salary" => 950.0,
                "published_at" => "2025-07-11 12:00:00"
            ]);

        $response->assertCreated()
            ->assertJsonStructure([
                "data" => [
                    "job_posting" => [
                        "id",
                        "client",
                        "title",
                        "description",
                        "salary",
                        "is_published",
                        "published_at"
                    ]
                ],
                "meta" => [
                    "message"
                ]
            ]);
    }

    public function test_client_can_create_job_posting_as_draft()
    {
        $token = $this->getToken("client");

        $response = $this->withHeader("Authorization", "Bearer {$token}")
            ->postJson(route("api.job-postings.store"), [
                "title" => "Membuat Website Freelancer",
                "description" => "Buatkan website freelancer",
                "salary" => 950.0
            ]);

        $response->assertCreated();

        $this->assertFalse($response->json("data.job_posting.is_published"));
    }

    public function test_freelancer_can_get_list_published_job_postings()
    {
        $token = $this->getToken("freelancer");

        $jobPosting = JobPosting::factory()
            ->for(
                User::factory()
                    ->for(
                        Role::factory()
                            ->state(["name" => "client"])
                    ),
                "client"
            )
            ->published()
            ->create();

        $response = $this->withHeader("Authorization", "Bearer {$token}")
            ->getJson(route("api.job-postings.index"));

        $response->assertOk()
            ->assertJsonStructure([
                "data" => [
                    "job_postings" => [
                        [
                            "id",
                            "client" => [
                                "id",
                                "role" => [
                                    "id",
                                ],
                            ],
                            "title",
                            "description",
                            "salary",
                            "published_at"
                        ]
                    ]
                ],
                "meta" => [
                    "message"
                ]
            ]);
    }
}
