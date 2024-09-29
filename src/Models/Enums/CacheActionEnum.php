<?php

namespace Profiler\Models\Enums;

enum CacheActionEnum: string
{
    case HIT = 'hit';
    case MISSED = 'missed';
    case FORGOTTEN = 'forgotten';
    case WRITTEN = 'written';
}
