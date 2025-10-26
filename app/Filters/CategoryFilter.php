<?php

namespace App\Filters;

class CategoryFilter extends QueryFilter
{
    public function search($term)
    {
        $this->builder->where('name', 'like', "%{$term}%");
    }

    public function sort($field)
    {
        $direction = request('direction', 'asc');

        if (in_array($field, ['name', 'updated_at'])) {
            $this->builder->orderBy($field, $direction);
        }
    }
}
