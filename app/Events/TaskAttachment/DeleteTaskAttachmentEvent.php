<?php

namespace App\Events\TaskAttachment;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteTaskAttachmentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $taskAttachment;

    public function __construct($taskAttachment)
    {
        $this->taskAttachment = $taskAttachment;
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->taskAttachment['id'] ?? null,
            'assignee_id' => $this->taskAttachment['assignee_id'] ?? null,
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('delete-task-attachment'),
        ];
    }

    public function broadcastAs()
    {
        return 'DeleteTaskAttachmentEvent';
    }
}
