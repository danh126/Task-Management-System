<?php

namespace App\Repositories;

use App\Interface\TaskLogRepositoryInterface;
use App\Models\Task_log;
use Illuminate\Http\Request;

class TaskLogRepository implements TaskLogRepositoryInterface
{
    private $taskLog;

    public function __construct(Task_log $taskLog)
    {
        $this->taskLog = $taskLog;
    }

    public function createTaskLog(Request $request)
    {
        $request->validate([
            'task_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'old_status' => ['required', 'max:11'],
            'new_status' => ['required', 'max:11'],
        ]);

        $task_log = $this->taskLog->create($request->toArray());
        return $task_log;
    }

    public function getTaskLogByTaskId($taskId)
    {
        return $this->taskLog->with(['user'])->where('task_id', $taskId)
            ->orderBy('created_at', 'desc')->get();
    }
}
