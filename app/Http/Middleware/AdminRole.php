<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\UserRole;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->role != UserRole::Administrator) {
            return abort('403', 'Unauthorized action.');
        }
        return $next($request);
    }
}
