<?php

namespace Profiler\Controllers;

use Illuminate\View\View;

class ProfilerController
{
    public function index(): View
    {
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
            'requests' => [
                [
                    'route' => 0,
                    'memory' => 0,
                    'time' => 0,
                ]
            ],
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
