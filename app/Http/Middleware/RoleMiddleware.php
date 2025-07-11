<?php

namespace App\Http\Middleware;

use App\Repositories\RoleRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        $roleRepository = app(RoleRepositoryInterface::class);

        $roles = $roleRepository->getByNames($roles);

        if (is_null($user) || is_null($roles->find($user->role_id))) {
            return response()->json(["meta" => ["message" => "Forbidden."]], 403);
        }

        return $next($request);
    }
}
