<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\JobPosting;
use App\Models\Application;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    public function createForUserForJobPosting(array $data, User $user, JobPosting $jobPosting): Application
    {
        $application = $jobPosting->applications()->make($data);

        $application->freelancer()->associate($user);

        $application->save();

        return $application;
    }
}
