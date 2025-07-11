<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ApplicationRequest;
use App\Services\ApplicationService;

class ApplicationController extends BaseAPIController
{
    public function __construct(
        protected ApplicationService $applicationService
    ) {}

    public function store(ApplicationRequest $request)
    {
        $application = $this->applicationService->applyJobPosting(
            $request->validated(),
            $request->file("cv"),
            $request->user()
        );

        return $this->success([
            "application" => $application->toResource()
        ], "Created.", 201);
    }
}
