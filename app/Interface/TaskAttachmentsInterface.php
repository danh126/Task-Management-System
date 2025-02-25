<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface TaskAttachmentsInterface
{
    public function createTaskAttachment(Request $request);
    public function saveFiles($files, $folder);
    public function getTaskAttachmentsByTaskId($taskId);
    public function fileConfrim($fileId);
    public function deleteFile($fileId);
}
