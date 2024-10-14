<?php

namespace App\Pipelines\Filters;

use Closure;

class OpeningTime
{
  public function handle($query, Closure $next)
  {
    // Apply the filter if the 'opening_time' exists in the request
    if (request()->has('opening_time')) {
      $query->where('opening_time', '>=', request('opening_time'));
    }

    return $next($query);
  }
}
