<?php

namespace App\Filters;

class UserFilter extends QueryFilter
{
    public function search($term)
    {
        $this->builder->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%");
        });
    }

    public function sort($field)
    {
        $direction = request('direction', 'asc');

        // Güvenli alan kontrolü
        if (in_array($field, ['name', 'email', 'updated_at'])) {
            $this->builder->orderBy($field, $direction);
        }
    }
}
