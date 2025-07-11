<?php

namespace App\Repositories;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface JobPostingRepositoryInterface
{
    public function listPublished(): Collection;

    public function findPublishedById(int $id): JobPosting;

    public function findDraftById(int $id): JobPosting;

    public function createForUser(array $data, User $user): JobPosting;

    public function getApplications(JobPosting $jobPosting): Collection;
}
