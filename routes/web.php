<?php

use Profiler\Controllers\ProfilerController;

\Illuminate\Support\Facades\Route::get('profiler', [ProfilerController::class, 'index'])
//    ->middleware(\Profiler\Middlewares\GuardMiddleware::class)
    ->name('flagsoft.profiler.index');
