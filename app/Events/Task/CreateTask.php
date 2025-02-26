<?php

namespace App\Events\Task;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateTask implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('task-created');
    }

    // Chuẩn bị data gửi đến client
    public function broadcastWith()
    {
        return [
            "title" => $this->task->title,
            "description" => $this->task->description,
            "priority" => $this->task->priority,
            "project_id" => $this->task->project_id,
            "due_date" => $this->task->due_date ?? null,
            "assignee_id" => $this->task->assignee_id,
            "updated_at" => $this->task->updated_at->format('Y-m-d') ?? null,
            "created_at" => $this->task->created_at->format('Y-m-d') ?? null,
            "id" => $this->task->id,
            "project_name" => $this->task->project->name ?? null,
            "user_name" => $this->task->assignee->name ?? null,
            "status" => $this->task->status
        ];
    }

    public function broadcastAs()
    {
        return 'CreateTask';
    }
}
