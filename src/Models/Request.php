<?php

namespace Profiler\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    protected $table = 'profiler_requests';

    public $timestamps = false;

    protected $fillable = [
        'profiler_route_id',
        'params',
        'body',
        'memory',
        'requested_at',
        'responsed_at',
    ];

    protected $casts = [
        'params' => 'array',
        'body' => 'array',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function queries(): HasMany
    {
        return $this->hasMany(Query::class);
    }

    public function cache(): HasMany
    {
        return $this->hasMany(Cache::class);
    }
}
