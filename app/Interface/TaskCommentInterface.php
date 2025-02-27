<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface TaskCommentInterface
{
    public function getTaskCommentsByTaskId ($taskId);
    public function createTaskComment (Request $request);
    public function deleteTaskComment ($taskCommentId);
}
