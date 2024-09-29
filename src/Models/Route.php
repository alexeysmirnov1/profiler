<?php

namespace Profiler\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = 'profiler_routes';

    public $timestamps = false;

    protected $fillable = [
        'method',
        'url',
        'controller',
        'action',
        'middleware',
        'routed_at',
    ];

    protected $casts = [
        'middleware' => 'array',
    ];
}
