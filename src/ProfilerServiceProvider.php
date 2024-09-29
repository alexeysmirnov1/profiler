<?php

namespace Profiler;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Cache\Events\KeyForgotten;
use Illuminate\Cache\Events\KeyWritten;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Facades\DB;
use Profiler\Models\Enums\CacheActionEnum;

class ProfilerServiceProvider extends EventServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/profiler.php', 'profiler',
        );

        $this->app->singleton(Profiler::class, Profiler::class);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'profiler');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../config/profiler.php' => config_path('profiler.php'),
        ]);

        if(config('profiler.enable')) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

            $this->catchDBQueries();
            $this->catchCache();
            $this->catchJobs();
        }
    }

    private function catchDBQueries(): void
    {
        DB::listen(function (QueryExecuted $query) {
            $location = collect(debug_backtrace())->filter(function ($trace) {
                return !str_contains($trace['file'], 'vendor');
            })->first();

            /** @var Profiler $profiler */
            $profiler = resolve(Profiler::class);
            $profiler->addRequestQuery(
                sql: $query->sql,
                point: implode(':', [$location['file'], $location['line']]),
                time: $query->time,
                executed_at: microtime(true),
            );
        });
    }

    private function catchCache(): void
    {
        $dispatcher = resolve(Dispatcher::class);
        /** @var Profiler $profiler */
        $profiler = resolve(Profiler::class);

        $dispatcher->listen(CacheHit::class, function(CacheHit $event) use ($profiler) {
            $profiler->addRequestCache($event->key, CacheActionEnum::HIT);
//            $profiler->cache[$event->key]['hits'][] = microtime(true);
        });

        $dispatcher->listen(CacheMissed::class, function(CacheMissed $event) use ($profiler) {
            $profiler->addRequestCache($event->key, CacheActionEnum::MISSED);
//            $profiler->cache[$event->key]['missed'][] = microtime(true);
        });

        $dispatcher->listen(KeyForgotten::class, function(KeyForgotten $event) use ($profiler) {
            $profiler->addRequestCache($event->key, CacheActionEnum::FORGOTTEN);
//            $profiler->cache[$event->key]['forgotten'][] = microtime(true);
        });

        $dispatcher->listen(KeyWritten::class, function(KeyWritten $event) use ($profiler) {
            $profiler->addRequestCache($event->key, CacheActionEnum::WRITTEN);
//            $profiler->cache[$event->key]['writen'][] = microtime(true);
        });
    }

    private function catchJobs(): void
    {
        $dispatcher = resolve(Dispatcher::class);
        /** @var Profiler $profiler */
        $profiler = resolve(Profiler::class);

        $dispatcher->listen(\Illuminate\Queue\Events\JobQueued::class, function ($event) use ($profiler) {
            $class = get_class($event->job);

//            $profiler->request['jobs'][] = [
//                'job' => $class,
//                'dispatched_at' => microtime(true),
//            ];
        });
    }
}
