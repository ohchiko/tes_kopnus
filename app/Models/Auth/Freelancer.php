<?php

namespace App\Models\Auth;

use Illuminate\Foundation\Auth\User;
use Laravel\Sanctum\HasApiTokens;

class Freelancer extends User
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
