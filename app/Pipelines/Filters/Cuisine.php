<?php

namespace App\Pipelines\Filters;

use Closure;

class Cuisine
{
  public function handle($query, Closure $next)
  {
    if (request()->has('cuisine')) {
      $query->where('cuisine', request('cuisine'));
    }

    return $next($query);
  }
}
