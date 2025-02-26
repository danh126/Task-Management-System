<?php

namespace App\Repositories;

use App\Events\TaskAttachment\CreateTaskAttachmentEvent;
use App\Events\TaskAttachment\DeleteTaskAttachmentEvent;
use App\Events\TaskAttachment\UpdateTaskAttachmentEvent;
use App\Interface\TaskAttachmentsInterface;
use App\Models\Task_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TaskAttachmentRepository implements TaskAttachmentsInterface
{
    private $taskAttachment;

    public function __construct(Task_attachment $taskAttachment)
    {
        $this->taskAttachment = $taskAttachment;
    }

    public function createTaskAttachment(Request $request)
    {
        $request->validate([
            'task_id' => ['required'],
            'uploaded_by' => ['required'],
        ]);

        $data = [];

        if (!$request->hasFile('files')) {
            return $data;
        }

        $uploadedFiles = $this->saveFiles($request->file('files'), 'task attachments');

        foreach ($uploadedFiles as $file) {
            $data = $file + [
                'task_id' => $request->task_id,
                'uploaded_by' => $request->uploaded_by
            ];

            $res = $this->taskAttachment->create($data);
            $res->load(['task']);

            broadcast(new CreateTaskAttachmentEvent($res));
        }

        return $data;
    }

    public function saveFiles($files, $keyword)
    {
        // Tạo thư mục tự động nếu chưa tồn tại
        $folder = 'uploads/' . strtolower(str_replace(' ', '_', $keyword));

        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder); // tạo folder tự động
        }

        $uploadedFiles = [];

        foreach ($files as $file) {
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file_path = $file->storeAs($folder, $file_name, 'public'); // dùng storeAs lưu tên file

            $uploadedFiles[] = [
                'file_name' => $file_name,
                'file_path' => asset('storage/' . $file_path) // trả về đường dẫn có thể truy cập
            ];
        }

        return $uploadedFiles;
    }

    public function getTaskAttachmentsByTaskId($taskId)
    {
        $taskAttachments = $this->taskAttachment->where('task_id', $taskId)
            ->orderBy('created_at', 'desc')->get();

        return $taskAttachments;
    }

    public function getTaskAttachmentsByProjectId($projectId)
    {
        $taskAttachments = $this->taskAttachment->with(['user'])->select('task_attachments.*')
            ->join('tasks', 'task_attachments.task_id', '=', 'tasks.id')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->where('projects.id', $projectId)->where('task_attachments.file_confrim', 1)
            ->orderBy('created_at', 'desc')->get();

        return $taskAttachments;
    }

    public function fileConfrim($fileId)
    {
        $file = $this->taskAttachment->with(['task'])->find($fileId);

        $file->file_confrim = 1;
        $file->save();

        broadcast(new UpdateTaskAttachmentEvent($file));

        return $file;
    }

    public function deleteFile($fileId)
    {
        $file = $this->taskAttachment->with(['task'])->find($fileId);

        $path = public_path('storage/uploads/task_attachments/' . $file->file_name);

        if (File::exists($path)) {
            File::delete($path);
        }

        $res = ['id' => $file->id, 'assignee_id' => $file->task->assignee_id];

        broadcast(new DeleteTaskAttachmentEvent($res));

        $file->delete();

        return $file;
    }
}
