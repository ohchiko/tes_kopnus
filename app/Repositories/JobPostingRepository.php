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

    public function createForUser(array $data, User $user): JobPosting
    {
        return $user->jobPostings()->create($data);
    }
}
