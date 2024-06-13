<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseStatusCodes;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthIsActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->is_active) {
            return $next($request);
        }

        return errorResponse(ResponseStatusCodes::UNAUTHORIZED, "Account Suspended", [], Response::HTTP_UNAUTHORIZED);

    }
}
