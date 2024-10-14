<?php

namespace App\Pipelines\Filters;

use Closure;

class Name
{
  public function handle($query, Closure $next)
  {
    // Apply the filter if the 'name' exists in the request
    if (request()->has('name')) {
      $query->where('name', 'like', '%' . request('name') . '%');
    }

    return $next($query);
  }
}
