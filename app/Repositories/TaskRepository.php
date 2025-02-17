<?php

namespace App\Repositories;

use App\Interface\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskRepository implements TaskRepositoryInterface{
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getTasks()
    {
        //
    }

    public function getTask($taskId)
    {
        //
    }

    public function createTask(Request $request)
    {
        //
    }

    public function updateTask($taskId, Request $request)
    {
        //
    }

    public function deleteTask($taskId)
    {
        //
    }
}