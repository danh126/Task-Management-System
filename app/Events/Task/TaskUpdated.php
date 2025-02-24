<?php

namespace App\Events\Task;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function broadcastOn()
    {
       return new PrivateChannel('task-updated');
    }

    public function broadcastWith()
    {
        return [
            "id" => $this->task->id,
            "title" => $this->task->title,
            "description" => $this->task->description,
            "status" => $this->task->status,
            "due_date" => $this->task->due_date,
            "project_id" => $this->task->project_id,
            'assignee_id' => $this->task->assignee_id
        ];
    }

    public function broadcastAs()
    {
        return 'TaskUpdated';
    }
}
