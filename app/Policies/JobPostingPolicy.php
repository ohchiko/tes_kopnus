<?php

namespace App\Policies;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPostingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view models.
     */
    public function view(User $user, JobPosting $jobPosting): bool
    {
        return $jobPosting->user_id === $user->getKey();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole("client");
    }

    /**
     * Determine whether the user can update models.
     */
    public function update(User $user, JobPosting $jobPosting): bool
    {
        return $jobPosting->user_id === $user->getKey();
    }
}
