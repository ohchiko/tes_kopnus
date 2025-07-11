<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    public function findById(int $id): Role;

    public function findByName(string $name): Role;

    public function getByNames(array $names): Collection;
}
