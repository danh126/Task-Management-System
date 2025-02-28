<?php

namespace App\Http\Controllers;

use App\Interface\TaskLogRepositoryInterface;
use Illuminate\Http\Request;

class TaskLogController extends Controller
{
    protected $taskLogRepository;

    public function __construct(TaskLogRepositoryInterface $taskLogRepository)
    {
        $this->taskLogRepository = $taskLogRepository;
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $task_log = $this->taskLogRepository->createTaskLog($request);

        return response([
            'task_log' => $task_log,
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function getTaskLogByTaskId(string $taskId)
    {
        $task_logs = $this->taskLogRepository->getTaskLogByTaskId($taskId);

        return response([
            'task_logs' => $task_logs,
        ]);
    }
}
