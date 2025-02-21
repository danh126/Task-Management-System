<?php

namespace App\Repositories;

use App\Events\Task\CreateTask;
use App\Events\Task\DeleteTask;
use App\Events\Task\TaskStatusUpdate;
use App\Events\Task\TaskUpdated;
use App\Interface\TaskRepositoryInterface;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Http\Request;

class TaskRepository implements TaskRepositoryInterface{
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getTasksByManager($managerId)
    {
        $tasks = $this->task->select('tasks.*', 'projects.name as project_name','users.name as user_name')
        ->join('projects','tasks.project_id','=','projects.id')
        ->join('users','users.id','=','tasks.assignee_id')
        ->where('projects.manager_id', $managerId)
        ->orderBy('key_priority','asc')->paginate(5);
        
        return $tasks;
    }
    
    public function getTasksByEmployee($employeeId)
    {
        $tasks = $this->task->select('tasks.*', 'projects.name as project_name','users.name as user_name')
        ->join('projects','tasks.project_id','=','projects.id')
        ->join('users','users.id','=','tasks.assignee_id')
        ->where('tasks.assignee_id', $employeeId)
        ->orderBy('key_priority','asc')->paginate(5);

        return $tasks;
    }

    public function getTasks()
    {
        $tasks = $this->task->select('tasks.*', 'projects.name as project_name','users.name as user_name')
        ->join('projects','tasks.project_id','=','projects.id')
        ->join('users','users.id','=','tasks.assignee_id')
        ->orderBy('key_priority','asc')->paginate(5);

        return $tasks;
    }

    public function createTask(Request $request)
    {
        $project = Project::find($request->project_id);

        $request->validate([
            'title' => ['required','max:150'],
            'description' => ['required'],
            'priority' => ['required','max:11'],
            'due_date' => [
                            'required',
                            'date',
                            'before:'. optional($project)->end_date,
                            'after:'. optional($project)->start_date
                        ],
            'project_id' => ['required'],
            'assignee_id' => ['required']
        ]);

        $task = $this->task->create($request->toArray());

        // Eager Load quan hệ assignee và project
        $task->load(['assignee','project']);

        // Gửi thông báo reail-time
        broadcast(new CreateTask($task));
    
        // Gửi mail thông báo
        $task->assignee->notify(new TaskAssignedNotification($task));

        return $task;
    }

    public function updateTask($taskId, Request $request)
    {
        $project = Project::find($request->project_id);

        $request->validate([
            'title' => ['required','max:150'],
            'description' => ['required'],
            'priority' => ['required','max:11'],
            'due_date' => [
                            'required',
                            'date',
                            'before:'. optional($project)->end_date,
                            'after:'. optional($project)->start_date
                        ],
            'project_id' => ['required']
        ]);

        $task = $this->task->find($taskId);
        $task->update($request->toArray());

        // Gửi thông báo real-time
        broadcast(new TaskUpdated($task));

        return $task;
    }

    public function updateTaskStatus($taskId, Request $request)
    {
        $request->validate([
            'status' => ['required','max:11']
        ]);
        
        $task = $this->task->find($taskId);
        $task->update($request->toArray());

        // Gửi thông báo real-time
        broadcast(new TaskStatusUpdate($task));

        return $task;
    }

    public function deleteTask($taskId)
    {
        $task = $this->task->find($taskId);

        $res = ['id' => $taskId,'assignee_id' => $task->assignee_id];

        // Gửi thông báo real-time
        broadcast(new DeleteTask($res));

        $task->delete();

        return $task;
    }
}