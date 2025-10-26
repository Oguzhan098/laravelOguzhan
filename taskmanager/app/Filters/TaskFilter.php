<?php

namespace App\Filters;

class TaskFilter extends QueryFilter
{
    public function search($term)
    {
        $this->builder
            ->where('title', 'like', "%{$term}%")
            ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$term}%"))
            ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$term}%"));
    }

    public function sort($field)
    {
        $direction = request('direction', 'asc');

        if (in_array($field, ['title', 'updated_at'])) {
            $this->builder->orderBy($field, $direction);
        }
    }
}
