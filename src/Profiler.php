<?php

namespace Profiler;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Profiler\Models\Cache;
use Profiler\Models\Enums\CacheActionEnum;
use Profiler\Models\Query;
use Profiler\Models\Route;

class Profiler
{
    protected array $request = [];

    protected bool $requestFinished = false;

    protected Collection $requestQueries;

    protected Collection $requestCache;

    public function __construct()
    {
        $this->requestQueries = new Collection();
        $this->requestCache = new Collection();
    }

    public function startRequest(Request $request): void
    {
        $this->request = [
            'route' => [
                'method' => $request->method(),
                'url' => $request->url(),
                'controller' => $request->route()->controller,
                'action' => $request->route()->getActionName(),
                'middleware' => $request->route()->getAction()['middleware'],
            ],
            'params' => $request->path(),
            'body' => $request->all(),
            'requested_at' => microtime(true),
        ];
    }

    public function finishRequest(): void
    {
        $this->request = [
            ...$this->request,
            'memory' => memory_get_usage(true),
            'responsed_at' => microtime(true),
        ];

        $this->requestFinished = true;
    }

    public function addRequestQuery(string $sql, string $point, float $time, float $executed_at): void
    {
        if($this->requestFinished) {
            return;
        }

        $this->requestQueries->add([
            'sql' => $sql,
            'point' => $point,
            'time' => $time,
            'executed_at' => $executed_at,
        ]);
    }

    public function addRequestCache(string $key, CacheActionEnum $action): void
    {
        $this->requestCache->add([
            'key' => $key,
            'action' => $action,
            'cached_at' => microtime(true),
        ]);
    }

    public function save(): void
    {
        $route = Route::withoutEvents(function () {
            return Route::create([
                'method' => $this->request['route']['method'],
                'url' => $this->request['route']['url'],
                'controller' => $this->request['route']['controller'] ?? 'null',
                'action' => $this->request['route']['action'],
                'middleware' => $this->request['route']['middleware'],
                'routed_at' => $this->request['requested_at'],
            ]);
        });

        $request = \Profiler\Models\Request::create([
            'profiler_route_id' => $route->id,
            'params' => $this->request['params'],
            'body' => $this->request['body'],
            'memory' => $this->request['memory'],
            'requested_at' => $this->request['requested_at'],
            'responsed_at' => $this->request['responsed_at'],
        ]);

        if($this->requestQueries->isNotEmpty()) {
            $this->requestQueries->each(fn($query) => Query::create([
                'profiler_request_id' => $request->id,
                'sql' => $query['sql'],
                'point' => $query['point'],
                'time' => $query['time'],
                'executed_at' => $query['executed_at'],
            ]));
        }

        if($this->requestCache->isNotEmpty()) {
            $this->requestCache->each(fn($cache) => Cache::create([
                'profiler_request_id' => $request->id,
                'key' => $cache['key'],
                'action' => $cache['action'],
                'cached_at' => $cache['cached_at'],
            ]));
        }
    }
}
