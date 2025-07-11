<?php

namespace App\Services;

use App\Models\JobPosting;
use App\Models\User;
use App\Repositories\JobPostingRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;

class JobPostingService
{
    public function __construct(
        protected JobPostingRepositoryInterface $jobPostingRepository
    ) {}

    public function listPublished(User $user): Collection
    {
        if ($user->cannot("viewAny", JobPosting::class)) {
            throw new AuthorizationException();
        }

        return $this->jobPostingRepository->listPublished();
    }

    public function create(array $data, User $user): JobPosting
    {
        if ($user->cannot("create", JobPosting::class)) {
            throw new AuthorizationException();
        }

        return $this->jobPostingRepository->createForUser($data, $user);
    }

    public function publish($dateTime, int $jobPosting, User $user): JobPosting
    {
        $jobPosting = $this->jobPostingRepository->findDraftById($jobPosting);

        if ($user->cannot("update", $jobPosting)) {
            throw new AuthorizationException();
        }

        $jobPosting->published_at = $dateTime;
        $jobPosting->save();

        return $jobPosting;
    }

    public function getApplications(int $jobPosting, User $user): Collection
    {
        $jobPosting = $this->jobPostingRepository->findPublishedById($jobPosting);

        if ($user->cannot("view", $jobPosting)) {
            throw new AuthorizationException();
        }

        return $this->jobPostingRepository->getApplications($jobPosting);
    }
}
