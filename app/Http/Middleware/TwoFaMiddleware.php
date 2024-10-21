<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class TwoFaMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Attempt to authenticate the user
            $user = JWTAuth::parseToken()->authenticate();

            // Get the user's role
            $roleName = $user->roles->pluck('name')->first();

            // Check if the user is an Admin or Restaurant Owner and verify 2FA
            if (in_array($roleName, ['Admin', 'Restaurant Owner']) && !$user->is_2fa_verified) {
                return response()->json(['error' => '2FA verification required.'], 403);
            }
        } catch (\Exception $e) {
            // Optionally log the exception for debugging
            // Log::error('JWT Authentication Error: ' . $e->getMessage());

            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        return $next($request);
    }
}
