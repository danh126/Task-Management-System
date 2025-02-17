<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface TaskRepositoryInterface
{
    public function getTasks();
    public function getTask($taskId);
    public function createTask(Request $request);
    public function updateTask($taskId, Request $request);
    public function deleteTask($taskId);
}
