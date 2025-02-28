<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface TaskLogRepositoryInterface
{
    public function createTaskLog(Request $request);
    public function getTaskLogByTaskId($taskId);
}
