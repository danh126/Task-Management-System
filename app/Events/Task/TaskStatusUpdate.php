<?php

namespace App\Events\Task;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskStatusUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    // Trong hàm này có thể return nhiều channel route
    public function broadcastOn()
    {
        return new PrivateChannel('task-status-update');
    }

    // Custom data
    public function broadcastWith(){
        return [
            'id' => $this->task->id,
            'status' => $this->task->status,
            'assignee_id' => $this->task->assignee_id
        ];
    }

    // Trả về Event
    public function broadcastAs()
    {
        return 'TaskStatusUpdate';
    }
}
