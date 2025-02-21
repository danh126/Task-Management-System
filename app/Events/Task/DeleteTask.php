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

class DeleteTask implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;
    
    public function __construct($task)
    {
        $this->task = $task;
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->task['id'] ?? null,
            'assignee_id' => $this->task['assignee_id'] ?? null
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('task-delete');
    }

    public function broadcastAs()
    {
        return 'DeleteTask';
    }
}
