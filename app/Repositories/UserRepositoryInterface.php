<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Finds a user by their email
     * 
     * @param  string  $email
     * 
     * @return \App\Models\User
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByEmail(string $email): User;
}