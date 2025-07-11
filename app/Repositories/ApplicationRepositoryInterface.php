<?php

namespace App\Repositories;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;

interface ApplicationRepositoryInterface
{
    public function createForUserForJobPosting(array $data, User $user, JobPosting $jobPosting): Application;
}
