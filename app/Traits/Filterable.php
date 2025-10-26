<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Filterable
{
    public function scopeFilter($query, Request $request)
    {
        $filterClass = "App\\Filters\\" . class_basename($this) . "Filter";

        if (class_exists($filterClass)) {
            $filter = new $filterClass($request);
            return $filter->apply($query);
        }

        return $query;
    }
}
