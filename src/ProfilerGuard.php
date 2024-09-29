<?php

namespace Profiler;

use Illuminate\Http\Request;

class ProfilerGuard
{
    public function __construct(
        private readonly Request $request)
    {
    }

    public function trust(): bool
    {
        return $this->request->header('X-Profiler-Guard-Token') === config('profiler.token');
    }
}
