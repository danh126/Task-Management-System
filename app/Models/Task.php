<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['id', 'title', 'description', 'status', 'priority', 'due_date', 'project_id', 'assignee_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Task_comment::class);
    }

    public function attachments(){
        return $this->hasMany(Task_attachment::class);
    }

    public function logs(){
        return $this->hasMany(Task_log::class);
    }

    // Định dạng lại date
    protected $dates = ['created_at','due_date'];

    public function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }
}
