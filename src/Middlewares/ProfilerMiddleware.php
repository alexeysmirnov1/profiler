<?php

namespace Profiler\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Profiler\Profiler;
use Profiler\ProfilerGuard;
use Symfony\Component\HttpFoundation\Response;

class ProfilerMiddleware
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        /** @var Profiler $profiler */
        $profiler = resolve(Profiler::class);

        $profiler->startRequest($request);

        return $next($request);
    }

    public function terminate(): void
    {
        /** @var Profiler $profiler */
        $profiler = resolve(Profiler::class);
        $profiler->finishRequest();
        $profiler->save();
    }
}
