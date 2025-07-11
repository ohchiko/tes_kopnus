<?php

namespace App\Models\Auth;

use App\Models\Vacancies;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;
use Laravel\Sanctum\HasApiTokens;

class Client extends User
{
    use HasApiTokens;

    protected $fillable = [
        "name",
        "email",
        "password",
    ];

    protected $hidden = [
        "password"
    ];
}
