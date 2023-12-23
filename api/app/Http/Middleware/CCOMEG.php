<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseStatusCodes;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CCOMEG
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
        if ($request->user()->position_id === '5' || $request->user()->role_id === Role::MEG) {
            return $next($request);
        }
        return errorResponse(ResponseStatusCodes::UNAUTHORIZED, "Unauthorized Access", [], Response::HTTP_UNAUTHORIZED);
    }
}
