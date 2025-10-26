<?php

namespace App;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, Filterable;

    protected $fillable = [
        'name',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
