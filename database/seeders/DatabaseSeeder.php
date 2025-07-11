<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $clientRole = Role::factory()->create(["name" => "client"]);
        $freelancerRole = Role::factory()->create(["name" => "freelancer"]);

        $clientUser = User::factory()->for($clientRole)->create([
            "email" => "client@example.org",
            "password" => "password"
        ]);

        $freelancerUser = User::factory()->for($freelancerRole)->create([
            "email" => "freelancer@example.org",
            "password" => "password"
        ]);

        $jobPosting = JobPosting::factory()->for($clientUser, "client")->create();

        $cv = UploadedFile::fake()->create("cv.pdf", 1024, "application/pdf");

        $cvPath = Storage::disk("application")->putFile("cv", $cv);

        $application = Application::factory()->for($jobPosting)->for($freelancerUser, "freelancer")->create([
            "cv_path" => $cvPath
        ]);
    }
}
