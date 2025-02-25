<?php

namespace App\Events\TaskAttachment;

use App\Models\Task_attachment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateTaskAttachmentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $taskAttachment;

    public function __construct(Task_attachment $taskAttachment)
    {
        $this->taskAttachment = $taskAttachment;
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->taskAttachment->id,
            'assignee_id' => $this->taskAttachment->task->assignee_id ?? null,
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('updated-task-attachment'),
        ];
    }

    public function broadcastAs()
    {
        return 'UpdateTaskAttachmentEvent';
    }
}
