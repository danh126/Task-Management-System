<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'manager_id'
    ];

    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('key_priority', 'asc');
    }

    // Phương thức tính tiến độ của dự án
    public function progress()
    {
        $totalTasks = $this->tasks()->count(); // đếm tổng số lượng tasks
        $completedTasks = $this->tasks()->where('status', 'done')->count(); // đếm số lượng task hoàn thành

        return $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    // Định dạng lại date
    protected $dates = ['start_date', 'end_date'];

    public function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }
}
