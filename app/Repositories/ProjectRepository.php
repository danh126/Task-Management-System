<?php

namespace App\Repositories;

use App\Interface\ProjectRepositoryInterface;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectRepository implements ProjectRepositoryInterface{
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function getProjects()
    {
        return $this->project->with('manager')->orderBy('created_at','desc')->paginate(5);
    }

    public function getProject($projectId)
    {
        //
    }

    public function getProjectByManagerPagination($managerId)
    {
        $projects = $this->project->with('manager')->where('manager_id', $managerId)->orderBy('created_at','desc')->paginate(5);
        return $projects;
    }

    public function getProjectByManager($managerId)
    {
        $projects = $this->project->where('manager_id', $managerId)->orderBy('created_at','desc')->get();
        return $projects;
    }

    public function createProject(Request $request)
    {
        $request->validate([
            'name' => ['required','max:200'],
            'description' => 'required',
            'start_date' => ['required', 'date', 'before:end_date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'manager_id' => 'required',
        ]);

        $project = $this->project->create($request->toArray());
        $project['status'] = 'pending';

        return $project;
    }

    public function updateProject($projectId, Request $request)
    {
        $request->validate([
            'name' => ['required','max:200'],
            'description' => 'required',
            'start_date' => ['required', 'date', 'before:end_date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'status' => 'required',
        ]);

        $project = $this->project->find($projectId);

        if($project){
            $project->update($request->toArray());
            return $project;
        }
    }

    public function deleteProject($projectId)
    {
        $project = $this->project->find($projectId);
        if($project){
            $project->delete();
            return $project;
        }
    }
}