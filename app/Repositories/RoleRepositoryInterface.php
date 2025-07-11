<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    /**
     * Finds a role by their id
     * 
     * @param  int  $id
     * 
     * @return \App\Models\Role
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(int $id): Role;

    /**
     * Finds a role by their name
     * 
     * @param  string  $name
     * 
     * @return \App\Models\Role
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByName(string $name): Role;

    /**
     * Get all roles with specified names
     * 
     * @param  array<string>  $names
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByNames(array $names): Collection;
}
