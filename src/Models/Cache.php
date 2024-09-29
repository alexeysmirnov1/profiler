<?php

namespace Profiler\Models;

use Illuminate\Database\Eloquent\Model;
use Profiler\Models\Enums\CacheActionEnum;

class Cache extends Model
{
    protected $table = 'profiler_caches';

    public $timestamps = false;

    protected $fillable = [
        'profiler_request_id',
        'key',
        'action',
        'cached_at',
    ];

    protected $casts = [
        'action' => CacheActionEnum::class,
    ];
}
