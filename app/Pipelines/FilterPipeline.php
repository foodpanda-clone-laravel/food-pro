<?php

namespace App\Pipelines;

use Illuminate\Pipeline\Pipeline;

class FilterPipeline
{
  public static function apply($query, $filters)
  {
    // Prepare pipeline and pass the query and filters to each filter class
    return app(Pipeline::class)
      ->send($query)
      ->through(self::getFilters($filters))
      ->thenReturn();
  }

  protected static function getFilters($filters)
  {
    // Loop through each filter and apply it
    return array_map(function ($filter) {
      return 'App\\Pipelines\\Filters\\' . ucfirst($filter);
    }, array_keys($filters));
  }
}
