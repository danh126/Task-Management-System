<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task_log extends Model
{
    protected $fillable = ['id', 'task_id', 'user_id', 'old_status', 'new_status'];

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
