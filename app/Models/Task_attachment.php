<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task_attachment extends Model
{
    protected $fillable = [
        'id',
        'task_id',
        'file_name',
        'file_path',
        'uploaded_by',
        'file_confrim'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Định dạng lại date
    protected $dates = ['created_at'];

    public function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i');
    }
}
