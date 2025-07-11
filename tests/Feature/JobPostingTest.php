<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_client_can_publish_saved_job_posting_draft()
    {
        $token = $this->getToken("client");

        $client = app(UserRepositoryInterface::class)->findByEmail("gregorio@example.org");

        $jobPosting = JobPosting::factory()
            ->for($client, "client")
            ->create();

        $response = $this->withHeader("Authorization", "Bearer {$token}")
            ->putJson(route("api.job-postings.publish", $jobPosting), [
                "published_at" => now()->toDateTimeString()
            ]);

        $response->assertOk();
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

    public function test_client_can_get_applications_with_cv_of_published_job_postings()
    {
        $token = $this->getToken("client");

        $client = app(UserRepositoryInterface::class)->findByEmail("gregorio@example.org");

        Storage::fake("application");

        $file = UploadedFile::fake()->create("cv.pdf", 1024, "application/pdf");
        $filePath = $file->store("cvs");

        $jobPosting = JobPosting::factory()
            ->for($client, "client")
            ->has(
                Application::factory()
                    ->for(
                        User::factory()
                            ->for(
                                Role::factory()->state(["name" => "freelancer"])
                            ),
                        "freelancer"
                    )
                    ->state([
                        "cv_path" => $filePath
                    ])
            )
            ->published()
            ->create();

        $response = $this->withHeader("Authorization", "Bearer {$token}")
            ->getJson(route("api.job-postings.applications", $jobPosting));

        $response->assertOk()
            ->assertJsonStructure([
                "data" => [
                    "applications" => [
                        [
                            "id",
                            "cv_path"
                        ]
                    ]
                ]
            ]);
    }
}
