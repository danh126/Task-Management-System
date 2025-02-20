<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Bạn có nhiệm vụ mới!')
                    ->greeting('Xin chào, '.$notifiable->name)
                    ->line('Bạn vừa được giao nhiệm vụ mới: '. $this->task->title)
                    ->action('Xem chi tiết', url('http://127.0.0.1:8000/spa/tasks'))
                    ->line('Vui lòng kiểm tra và thực hiện nhiệm vụ!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
