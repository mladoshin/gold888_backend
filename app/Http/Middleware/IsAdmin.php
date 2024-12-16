<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user() &&  (auth()->user()->role == 'admin' || auth()->user()->role == 'region_director' || auth()->user()->role == 'director')) {
            return $next($request);
        }

        return $this->errorResponse('You have not admin access');
    }
}
