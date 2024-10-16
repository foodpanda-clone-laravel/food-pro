<?php

namespace App\Pipelines\Filters;

use Closure;

class OrderTypeFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('order_type')) {
            $query->where('order_type', request()->order_type);
        }

        return $next($query);
    }
}
