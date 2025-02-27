<?php

namespace App\Events\TaskComment;

use App\Models\Task_comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateTaskCommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task_comment; 

    public function __construct(Task_comment $task_comment)
    {
        $this->task_comment = $task_comment;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('create-task-comment');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->task_comment->id,
            'task_id' => $this->task_comment->task_id,
            'assignee_id' => $this->task_comment->task->assignee_id,
            'user' => $this->task_comment->user,
            'comment' => $this->task_comment->comment,
            'created_at' => $this->task_comment->created_at->format('d-m-Y H:i')
        ];
    }

    public function broadcastAs()
    {
        return 'CreateTaskCommentEvent';
    }
}
