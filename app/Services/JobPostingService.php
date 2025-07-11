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
        if (! $user->can("viewAny", JobPosting::class)) {
            throw new AuthorizationException();
        }

        return $this->jobPostingRepository->listPublished();
    }

    public function create(array $data, User $user): JobPosting
    {
        if (! $user->can("create", JobPosting::class)) {
            throw new AuthorizationException();
        }

        return $this->jobPostingRepository->createForUser($data, $user);
    }

    public function publish(JobPosting $jobPosting, $dateTime = null): JobPosting
    {
        $jobPosting->published_at = $dateTime;
        $jobPosting->save();

        return $jobPosting;
    }
}
