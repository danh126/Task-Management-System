<?php

namespace App\Repositories;

use App\Events\TaskComment\CreateTaskCommentEvent;
use App\Events\TaskComment\DeleteTaskCommentEvent;
use App\Interface\TaskCommentInterface;
use App\Models\Task_comment;
use Illuminate\Http\Request;

class TaskCommentRepository implements TaskCommentInterface
{
     private $task_comment;

     public function __construct(Task_comment $task_comment)
     {
          $this->task_comment = $task_comment;
     }

     public function getTaskCommentsByTaskId($taskId)
     {
          $task_comments = $this->task_comment->with(['user'])->where('task_id', $taskId)
               ->orderBy('created_at', 'desc')->get();

          return $task_comments;
     }

     public function createTaskComment(Request $request)
     {
          $request->validate([
               'task_id' => ['required', 'integer'],
               'user_id' => ['required', 'integer'],
               'comment' => ['required', 'max:200']
          ]);

          $task_comment = $this->task_comment->create($request->toArray());
          $task_comment->load(['user', 'task']);

          broadcast(new CreateTaskCommentEvent($task_comment));

          return $task_comment;
     }

     public function deleteTaskComment($taskCommentId)
     {
          $task_comment = $this->task_comment->with(['task'])->find($taskCommentId);

          $res = [
               'id' => $task_comment->id,
               'assignee_id' => $task_comment->task->assignee_id
          ];

          $task_comment->delete();

          broadcast(new DeleteTaskCommentEvent($res));

          return $res;
     }
}
