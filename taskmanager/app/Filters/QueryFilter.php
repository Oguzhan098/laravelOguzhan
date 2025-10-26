<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name) && $value !== null && $value !== '') {
                $this->$name($value);
            }
        }

        return $this->builder;
    }

    public function filters()
    {
        return $this->request->all();
    }
}
