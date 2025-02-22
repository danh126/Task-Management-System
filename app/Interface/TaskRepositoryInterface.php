<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface TaskRepositoryInterface
{
    public function getTasksByManager($managerId);
    public function getTasksByEmployee($employeeId);
    public function getTasks();
    public function createTask(Request $request);
    public function updateTask($taskId, Request $request);
    public function updateTaskStatus($taskId, Request $request);
    public function updatePriority($taskId, Request $request);
    public function deleteTask($taskId);
}
