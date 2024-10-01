<?php

namespace Profiler\Controllers;

use Illuminate\View\View;
use Profiler\Models\Request;
use Profiler\Resources\RequestIndexResource;

class ProfilerController
{
    public function index(): View
    {
//        dd(
//            now()->subHours(6)->unix(),
//            microtime(true),
//        );
        $from = now()->subHours(6)->unix();

        $requests = Request::with('route')
            ->where('requested_at', '>', $from)
            ->latest('requested_at')
            ->get();
//dd(
////    $requests,
//    RequestIndexResource::collection($requests)->jsonSerialize(),
//);
        return view('profiler::index', [
            'usage' => [
                'web' => [
                    [
                        'user' => 'admin',
                        'times' => 13,
                    ],
                    [
                        'user' => 'guest',
                        'times' => 413,
                    ],
                ],
                'api' => [],
                'admin' => [],
            ],
            'requests' => RequestIndexResource::collection($requests),
            'queries' => [
                [
                    'query' => [
                        'sql' => '',
                        'point' => '',
                    ],
                    'count' => 0,
                    'time' => 3,
                ]
            ],
            'cache' => [
                [
                    'key' => '',
                    'hits' => 0,
                ]
            ],
            'routes' => [
                [
                    'method' => '',
                    'route' => [
                        'route' => '',
                        'controller' => '',
                        'method' => '',
                    ],
                    'count' => 0,
                    'time' => 3,
                ],
            ],
            'queue' => [
                []
            ]
        ]);
    }
}
