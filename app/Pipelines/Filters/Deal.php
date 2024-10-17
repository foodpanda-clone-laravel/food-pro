<?php

namespace App\Pipelines\Filters;

use Closure;

class Deal
{
  public function handle($query, Closure $next)
  {
    if (request()->has('deal')) {
      $query->whereHas('deals', function ($q) {
        $q->where('discount', '>', 0);
      });
    }

    return $next($query);
  }
}
