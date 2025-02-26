<?php

namespace App\Http\Controllers;

use App\Interface\TaskAttachmentsInterface;
use Illuminate\Http\Request;

class TaskAttachmentController extends Controller
{
    protected $taskAttachmentRepository;

    public function __construct(TaskAttachmentsInterface $taskAttachmentRepository)
    {
        $this->taskAttachmentRepository = $taskAttachmentRepository;
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $uploadedFiles = $this->taskAttachmentRepository->createTaskAttachment($request);

        return response([
            'uploadedFiles' => $uploadedFiles
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
        $file = $this->taskAttachmentRepository->deleteFile($id);

        return response([
            'result' => $file
        ]);
    }

    public function getTaskAttachmentsByTaskId($taskId)
    {
        $taskAttachments = $this->taskAttachmentRepository->getTaskAttachmentsByTaskId($taskId);

        return response([
            'task_attachments' => $taskAttachments
        ]);
    }

    public function getTaskAttachmentsByProjectId($projectId)
    {
        $taskAttachments = $this->taskAttachmentRepository->getTaskAttachmentsByProjectId($projectId);

        return response([
            'task_attachments' => $taskAttachments
        ]);
    }

    public function fileConfrim($fileId)
    {
        $file = $this->taskAttachmentRepository->fileConfrim($fileId);

        return response([
            'file' => $file
        ]);
    }
}
