<?php

namespace App\Repositories;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class JobPostingRepository implements JobPostingRepositoryInterface
{
    public function listPublished(): Collection
    {
        return JobPosting::published()->get();
    }

    public function findPublishedById(int $id): JobPosting
    {
        return JobPosting::published()->findOrFail($id);
    }

    public function findDraftById(int $id): JobPosting
    {
        return JobPosting::draft()->findOrFail($id);
    }

    public function createForUser(array $data, User $user): JobPosting
    {
        return $user->jobPostings()->create($data);
    }

    public function getApplications(JobPosting $jobPosting): Collection
    {
        return $jobPosting->applications;
    }
}
