<?php

namespace App\Services;

use App\Models\Application;
use App\Models\User;
use App\Repositories\ApplicationRepositoryInterface;
use App\Repositories\JobPostingRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\UploadedFile;

class ApplicationService
{
    public function __construct(
        protected ApplicationRepositoryInterface $applicationRepository,
        protected JobPostingRepositoryInterface $jobPostingRepository
    ) {}

    public function applyJobPosting(array $data, UploadedFile $cv, User $user): Application
    {
        if ($user->cannot("create", Application::class)) {
            throw new AuthorizationException();
        }

        $jobPosting = $this->jobPostingRepository->findPublishedById($data["job_posting_id"]);

        $cvPath = $cv->store("cvs");

        return $this->applicationRepository->createForUserForJobPosting(
            ["cv_path" => $cvPath],
            $user,
            $jobPosting
        );
    }
}
