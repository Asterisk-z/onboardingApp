<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseStatusCodes;
use App\Models\Position;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CCO
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
        $cco_position = Position::where('name', Position::CCO)->first();

        if ($request->user()->position_id === $cco_position->id) {
            return $next($request);
        }
        return errorResponse(ResponseStatusCodes::UNAUTHORIZED, "Unauthorized Access", [], Response::HTTP_UNAUTHORIZED);
    }
}
