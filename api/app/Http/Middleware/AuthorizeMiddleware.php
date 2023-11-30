<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permissions)
    {
        try {
            $secret = env('JWT_SECRET');
            $token = $request->bearerToken();
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            $decoded_array = (array) $decoded;
            $user_permissions = $decoded_array['permissions'];
            if (strlen($permissions) && !in_array($permissions, $user_permissions)) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], Response::HTTP_FORBIDDEN);
            }
            $request->attributes->set('data', $decoded_array);
            return $next($request);

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
