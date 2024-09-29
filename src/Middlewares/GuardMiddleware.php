<?php

namespace Profiler\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Profiler\ProfilerGuard;
use Symfony\Component\HttpFoundation\Response;

class GuardMiddleware
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guard = new ProfilerGuard($request);
        if(!$guard->trust()) {
            abort(401);
        }

        return $next($request);
    }
}
