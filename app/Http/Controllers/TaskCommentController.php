<?php

namespace App\Http\Controllers;

use App\Interface\TaskCommentInterface;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    protected $taskCommentRepository;

    public function __construct(TaskCommentInterface $taskCommentRepository)
    {
        $this->taskCommentRepository = $taskCommentRepository;
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $task_comment = $this->taskCommentRepository->createTaskComment($request);

        return response([
            'task_comment' => $task_comment
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
        $task_comment = $this->taskCommentRepository->deleteTaskComment($id);

        return response([
            'task_comment' => $task_comment
        ]);
    }

    public function getTaskCommentsByTaskId($taskId)
    {
        $task_comments = $this->taskCommentRepository->getTaskCommentsByTaskId($taskId);

        return response([
            'task_comments' => $task_comments
        ]);
    }
}
