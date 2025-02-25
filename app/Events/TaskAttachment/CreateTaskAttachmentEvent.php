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

class CreateTaskAttachmentEvent implements ShouldBroadcast
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
            'task_id' => $this->taskAttachment->task_id,
            'file_name' => $this->taskAttachment->file_name,
            'file_path' => $this->taskAttachment->file_path,
            'uploaded_by' => $this->taskAttachment->uploaded_by,
            'file_confrim' => $this->taskAttachment->file_confrim,
            'assignee_id' => $this->taskAttachment->task->assignee_id ?? null,
            'created_at' => $this->taskAttachment->created_at->format('d=m-Y H:i')
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('create-task-attachment'),
        ];
    }

    public function broadcastAs()
    {
        return 'CreateTaskAttachmentEvent';
    }
}
