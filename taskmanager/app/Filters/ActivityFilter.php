<?php

namespace App\Filters;

class ActivityFilter extends QueryFilter
{
    public function search($term)
    {
        $this->builder->where('action', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%")
            ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$term}%"))
            ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$term}%"));
    }

    public function sort($field)
    {
        $direction = request('direction', 'asc');

        if (in_array($field, ['action', 'updated_at'])) {
            $this->builder->orderBy($field, $direction);
        }
    }
}

