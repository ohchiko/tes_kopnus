<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function login(array $data): string
    {
        $user = $this->userRepository->findByEmail($data["email"]);

        if (! $this->checkPassword($user, $data["password"])) {
            throw ValidationException::withMessages(["email" => ["Invalid credentials."]]);
        }

        return $this->createToken($user);
    }

    public function checkPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    public function createToken(User $user): string
    {
        return $user->createToken("{$user->role->name}-token")->plainTextToken;
    }
}
