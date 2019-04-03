<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class TaskState extends Model
{
    /**
     * Listing tasks having this state
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
