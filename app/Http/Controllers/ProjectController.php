<?php

namespace App\Http\Controllers;

use App\Interface\ProjectRepositoryInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index()
    {
        return $this->projectRepository->getProjects();
    }

    public function store(Request $request)
    {
        $project = $this->projectRepository->createProject($request);

        return response([
            'project' =>  $project
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $project = $this->projectRepository->updateProject($id,$request);
        return response([
            'project' => $project
        ]);
    }

    public function destroy(string $id)
    {
        $project = $this->projectRepository->deleteProject($id);

        return response([
            'result' => $project
        ]);
    }

    public function getProjectByManagerPagination($managerId){
        return $this->projectRepository->getProjectByManagerPagination($managerId);
    }

    public function getProjectByManager($managerId)
    {
        $projects = $this->projectRepository->getProjectByManager($managerId);

        return response([
            'projects' => $projects
        ]);
    }
}
