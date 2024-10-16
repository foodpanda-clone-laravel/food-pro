<?php

namespace App\Pipelines;

use Illuminate\Pipeline\Pipeline;

class FilterPipeline
{
  public static function apply($query, $filters)
  {
    return app(Pipeline::class)
      ->send($query)
      ->through(self::getFilters($filters))
      ->thenReturn();
  }

  protected static function getFilters($filters)
  {
    return array_map(function ($filter) {
      return 'App\\Pipelines\\Filters\\' . ucfirst($filter);
    }, array_keys($filters));
  }
}
