<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCourse
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
        if($request->user()->course()->first()->id != $request->route()->parameter('id')) {
            return redirect()->back();
        }
        return $next($request);
    }
}
