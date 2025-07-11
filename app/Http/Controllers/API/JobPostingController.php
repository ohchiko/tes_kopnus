<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\JobPostingRequest;
use App\Http\Requests\PublishJobPostingRequest;
use App\Models\JobPosting;
use App\Services\JobPostingService;
use Illuminate\Http\Request;

class JobPostingController extends BaseAPIController
{
    public function __construct(
        protected JobPostingService $jobPostingService
    ) {}

    public function index(Request $request)
    {
        $jobPostings = $this->jobPostingService->listPublished($request->user());

        return $this->success([
            "job_postings" => $jobPostings->toResourceCollection()
        ]);
    }

    public function store(JobPostingRequest $request)
    {
        $jobPosting = $this->jobPostingService->create($request->validated(), $request->user());

        return $this->success([
            "job_posting" => $jobPosting->toResource()
        ], "Created.", 201);
    }

    public function publish(PublishJobPostingRequest $request, JobPosting $jobPosting)
    {
        $jobPosting = $this->jobPostingService->publish($jobPosting, $request->validated("published_at"));

        return $this->success([
            "job_posting" => $jobPosting->toResource()
        ], "Published.", 200);
    }
}
