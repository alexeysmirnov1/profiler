<?php

namespace Profiler\Models;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $table = 'profiler_queries';

    public $timestamps = false;

    protected $fillable = [
        'profiler_request_id',
        'sql',
        'point',
        'time',
        'executed_at',
    ];
}
