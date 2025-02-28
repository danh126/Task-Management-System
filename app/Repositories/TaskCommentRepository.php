<?php

namespace App\Repositories;

use App\Events\TaskComment\CreateTaskCommentEvent;
use App\Events\TaskComment\DeleteTaskCommentEvent;
use App\Interface\TaskCommentInterface;
use App\Models\Task_comment;
use Illuminate\Http\Request;

class TaskCommentRepository implements TaskCommentInterface
{
     private $taskComment;

     public function __construct(Task_comment $taskComment)
     {
          $this->taskComment = $taskComment;
     }

     public function getTaskCommentsByTaskId($taskId)
     {
          $task_comments = $this->taskComment->with(['user'])->where('task_id', $taskId)
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

          $task_comment = $this->taskComment->create($request->toArray());
          $task_comment->load(['user', 'task']);

          broadcast(new CreateTaskCommentEvent($task_comment));

          return $task_comment;
     }

     public function deleteTaskComment($taskCommentId)
     {
          $task_comment = $this->taskComment->select('id', 'task_id')->find($taskCommentId);
          $assignee_id = $task_comment->task()->pluck('assignee_id')->first();

          $res = [
               'id' => $task_comment->id,
               'assignee_id' => $assignee_id
          ];

          $task_comment->delete();

          broadcast(new DeleteTaskCommentEvent($res));

          return $res;
     }
}
