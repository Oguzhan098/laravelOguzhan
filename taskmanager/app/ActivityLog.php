<?php

namespace App;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes, Filterable;

    protected $fillable = [
        'user_id',
        'task_id',
        'action',
        'description',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * 🔹 Logu oluşturan kullanıcı
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔹 Logun ait olduğu görev
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
