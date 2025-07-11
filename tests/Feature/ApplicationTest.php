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

class ApplicationTest extends TestCase
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

    public function test_freelancer_can_apply_to_published_job_posting_with_cv()
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

        Storage::fake("application");

        $file = UploadedFile::fake()->create("cv.pdf", 1024, "application/pdf");

        $response = $this->withHeader("Authorization", "Bearer {$token}")
            ->postJson(route("api.applications.store"), [
                "job_posting_id" => $jobPosting->getKey(),
                "cv" => $file
            ]);

        $response->assertCreated()
            ->assertJsonStructure([
                "data" => [
                    "application" => [
                        "id",
                        "jobPosting",
                        "freelancer",
                        "cv_path",
                        "is_approved",
                        "approved_at",
                        "is_completed",
                        "completed_at"
                    ]
                ]
            ]);

        $filePath = $response->json("data.application.cv_path");

        Storage::disk("application")->assertExists($filePath);
    }
}
