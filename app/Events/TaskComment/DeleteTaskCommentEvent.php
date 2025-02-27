<?php

namespace App\Events\TaskComment;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteTaskCommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task_comment;

    public function __construct($task_comment)
    {
        $this->task_comment = $task_comment;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('delete-task-comment');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->task_comment['id'],
            'assignee_id' => $this->task_comment['assignee_id']
        ];
    }

    public function broadcastAs()
    {
        return 'DeleteTaskCommentEvent';
    }
}
