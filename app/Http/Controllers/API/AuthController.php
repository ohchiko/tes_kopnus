<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends BaseAPIController
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        return $this->success([
            "token" => $token
        ]);
    }
}
