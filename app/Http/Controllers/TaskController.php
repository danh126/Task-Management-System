<?php

namespace App\Http\Controllers;

use App\Events\Task\DeleteTask;
use App\Interface\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $tasks = $this->taskRepository->getTasks();

        return response([
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request)
    {
        $task = $this->taskRepository->createTask($request);

        return response([
            'task' => $task
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $task = $this->taskRepository->updateTask($id, $request);
        
        return response([
            'task' => $task
        ]);
    }

    public function destroy(string $id)
    {
        $task = $this->taskRepository->deleteTask($id);

        return response([
            'result' => $task
        ]);
    }

    public function getTasksByManager($managerId)
    {
        $tasks = $this->taskRepository->getTasksByManager($managerId);

        return response([
            'tasks' => $tasks
        ]);
    }

    public function getTasksByEmployee($employee)
    {
        $tasks = $this->taskRepository->getTasksByEmployee($employee);

        return response([
            'tasks' => $tasks
        ]);
    }

    public function updateTaskStatus($taskId, Request $request)
    {
        $task = $this->taskRepository->updateTaskStatus($taskId, $request);

        return response([
            'task' => $task
        ]);
    }
}
