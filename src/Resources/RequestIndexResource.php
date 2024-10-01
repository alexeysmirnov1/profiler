<?php

namespace Profiler\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class RequestIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'method' => $this->route->method,
            'url' => $this->route->url,
            'params' => '',//$this->params,
            'body' => '',//$this->body,
            'server' => '',
            'sent_at' => Carbon::parse($this->requested_at)->toDateTimeString(),
            'time' => $this->responsed_at - $this->requested_at,
            'memory' => $this->memory,
        ];
    }
}
