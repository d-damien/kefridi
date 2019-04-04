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
    protected $hidden = ['user_id', 'task_state_id', 'updated_at'];
    protected $appends = ['state'];
    protected $fillable = ['user_id', 'task_state_id', 'title', 'detail', 'link'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // accessor : $task->state
    public function getStateAttribute()
    {
        return $this->belongsTo(TaskState::class, 'task_state_id')->first();
    }

    public function relevantDate() {
        $stateToDate = [
            1 => $this->created_at,
            2 => $this->started_at,
            3 => $this->ended_at
        ];

        return $stateToDate[$this->state->id];
    }

}
