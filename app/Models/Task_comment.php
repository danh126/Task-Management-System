<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task_comment extends Model
{
    protected $fillable = [
        'id',
        'task_id',
        'user_id',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Định dạng lại date
    protected $dates = ['created_at'];

    public function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i');
    }
}
