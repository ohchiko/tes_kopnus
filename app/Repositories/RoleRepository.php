<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    public function findByName(string $name): Role
    {
        return Role::where("name", $name)->firstOrFail();
    }

    public function getByNames(array $names): Collection
    {
        return Role::whereIn("name", $names)->get();
    }
}
