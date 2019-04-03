<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task as Task;
use App\Models\TaskState as TaskState;
use App\Models\User as User;

class Task extends Model
{
    // store timestamps in Unix format
    protected $dateFormat = 'U';
    protected $hidden = ['id', 'user_id', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function state()
    {
        return $this->belongsTo(TaskState::class, 'task_state_id');
    }
}
