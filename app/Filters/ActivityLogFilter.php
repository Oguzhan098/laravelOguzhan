<?php

namespace App\Filters;

class ActivityLogFilter extends QueryFilter
{
    public function search($term)
    {
        $this->builder
            ->where('action', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%")
            ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$term}%"))
            ->orWhereHas('task', fn($q) => $q->where('title', 'like', "%{$term}%"));
    }

    public function sort($field)
    {
        $direction = request('direction', 'asc');

        if (in_array($field, ['action', 'updated_at'])) {
            $this->builder->orderBy($field, $direction);
        }
    }
}
